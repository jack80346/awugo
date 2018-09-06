<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Hotel;
use App\Awugo\HotelAuth\HotelService;
use App\Awugo\HotelAuth\HotelServicePhotos;
use App\Awugo\Auth\Service;
use Image;
use View;
use DB;
use Validator;
use Debugbar;
use Carbon;
use File;

class ServiceController extends Controller
{
	// 服務設施介面
    public function main($country, $hotel_id){

        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));
        //
        $ServiceGroups =Service::where('parent',-1)->OrderBy('sort','desc')->get();
        //
        $ServiceItems =Service::where('parent','!=',-1)->OrderBy('sort','desc')->get();
        //
        $HotelServiceID =HotelService::where('hotel_list_id',substr($hotel_id, 1))->get(['service_list_id'])->toArray();
        $HotelServiceArray =array();
        foreach($HotelServiceID as $key => $id){
            array_push($HotelServiceArray, $id['service_list_id']);
        }
        // print_r();
        // exit;
        $binding =[
            'Title' => '設施與服務',
            'Nav_ID' => 10,  //功能按鈕編號  
            'Hotel_ID' => $hotel_id,
            'Hotel' =>$Hotel,
            'HotelServiceID' =>$HotelServiceArray,
            'ServiceGroups' =>$ServiceGroups,
            'ServiceItems' =>$ServiceItems,
            'Country' => $country,
        ];
    	return view('hotel_auth.service',$binding);
    }

    // 服務設施修改處理
    public function mainPost($country, $hotel_id){
        //
        $request =request()->all();
        $chk_service =(!empty($request['service']))?$request['service']:'';
        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));
        //
        $ServiceGroups =Service::where('parent',-1)->OrderBy('sort','desc')->get();
        //
        $ServiceItems =Service::where('parent','!=',-1)->OrderBy('sort','desc')->get();
        //
        $HotelService =HotelService::where('hotel_list_id',substr($hotel_id, 1));
        $HotelService->delete();
        //
        // $HotelServicePhoto =HotelServicePhotos::whereIN('hotel_service_id', $chk_service)->where('hotel_list_id', substr($hotel_id, 1));
        // $HotelServicePhoto->delete();
        
        //寫入新勾選值
        foreach ($chk_service as $key => $service) {
            $HotelService = new HotelService;
            $HotelService->hotel_list_id =substr($hotel_id, 1);
            $HotelService->service_list_id =$service;
            $HotelService->creator_id =session()->get('hotel_manager_id');
            $HotelService->creator_name =session()->get('hotel_manager_name');
            $HotelService->save();
        }

        // return 1;
        return redirect()->back();
    }
    
    //設施服務照片上傳介面
    public function photoPlan($country, $hotel_id, $service_id){
        app('debugbar')->disable();
        
        $ServiceInfo =HotelServicePhotos::where('hotel_list_id',substr($hotel_id,1))->where('hotel_service_id',$service_id)->get()->first();
        $ServiceName =Service::select('service_name')->where('nokey',$service_id)->get()->first();
        // dd($ServiceInfo);
        $binding =[
            'ServiceID' => $service_id,
            'ServiceName' => $ServiceName,
            'ServiceInfo' => $ServiceInfo,
        ];
        return view('hotel_auth.service_photo', $binding);
    }
    //設施服務修改資訊POST
    public function photoPlanPost($country, $hotel_id, $service_id){
        //app('debugbar')->disable();
        $request =request()->all();
        $hotel_id =substr(session()->get('hotel_id'),1);
        $created_id=session()->get('hotel_manager_id');
        $created_name=session()->get('hotel_manager_name');
        //
        $photo_record =HotelServicePhotos::where('hotel_list_id',$hotel_id)->where('hotel_service_id',$service_id)->count();
        if($photo_record >0){
            // Debugbar::info(1);
            $ServiceInfo =HotelServicePhotos::where('hotel_list_id',$hotel_id)->where('hotel_service_id',$service_id)->get()->first();
        }else{
            // Debugbar::info(2);
            $ServiceInfo =new HotelServicePhotos;
        }
        $ServiceInfo->hotel_service_id =$service_id;
        $ServiceInfo->hotel_list_id =$hotel_id;
        $ServiceInfo->creator_id =$created_id;
        $ServiceInfo->creator_name =$created_name;
        $ServiceInfo->cost =$request['cost'];
        $ServiceInfo->period =$request['period'];
        $ServiceInfo->comm =$request['comm'];
        $ServiceInfo->save();

        return 1;
        //return redirect()->to("/tw/auth/h".$hotel_id."/service_photo/".$service_id);
    }
    //刪除設施服務修改資訊POST
    public function photoPlanDel($country, $hotel_id, $service_id){
        $request =request()->all();
        $ServiceInfo =HotelServicePhotos::where('hotel_list_id',substr($hotel_id,1))->where('hotel_service_id',$service_id)->first();
        $ServiceInfo->photo='';
        $ServiceInfo->save();

        return redirect()->back();
    }
    //設施服務照片上傳處理
    public function photoPlanUpload(Request $request, $country, $hotel_id, $service_id){
        app('debugbar')->enable();
        ini_set('memory_limit', '256M');
        $photos_path = public_path('/photos/service');
        //
        $hotel_id =substr(session()->get('hotel_id'),1);
        $created_id=session()->get('hotel_manager_id');
        $created_name=session()->get('hotel_manager_name');
        //判斷是否已有照片，如有就是取代
        $photo_record =HotelServicePhotos::where('hotel_list_id',$hotel_id)->where('hotel_service_id',$service_id)->count();
        //
        $photos = $request->file('service_photo');

        if (!is_dir($photos_path)) {
            mkdir($photos_path, 0777);
        }
        $photo = $photos;
        $width = 0;
        $height = 0;
        list($width, $height) = getimagesize($photos);
        
        
        // $name = sha1(date('YmdHis') . str_random(30));
        $name =date("YmdHis").'_'.$hotel_id.'_'.(explode(' ', microtime())[0]*100000000);
        $save_name = $name . '.' . $photo->getClientOriginalExtension();
        if($photo_record >0){
            $photo_info =HotelServicePhotos::where('hotel_list_id',$hotel_id)->where('hotel_service_id',$service_id)->first();
            if(!empty($photo_info->photo) && $photo_info->photo !=null){
                $save_name =$photo_info->photo;
            }
        }
        $sub_name =$photo->getClientOriginalExtension();
        // $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();
        // 直立照片
        if($height >$width){
            $ss1_dir =85;$s1_dir =null;
            $ss2_dir =250;$s2_dir =null;
            $ss3_dir =600;$s3_dir =null;
        }else{
        // 橫立照片
            //各尺寸縮圖資料夾
            $s1_dir =100;$ss1_dir =null;
            $s2_dir =250;$ss2_dir =null;
            $s3_dir =800;$ss3_dir =null;
        }
        //縮圖1  60
        Image::make($photo)
            ->resize($s1_dir, $ss1_dir, function ($constraints) {
                $constraints->aspectRatio();
            })
            ->save($photos_path . '/100/' . $save_name);
            // $photo->move($photos_path. '/'.$s1_dir.'/', $save_name);
        //縮圖2  250
        Image::make($photo)
            ->resize($s2_dir, $ss2_dir, function ($constraints) {
                $constraints->aspectRatio();
            })
            ->save($photos_path . '/250/' . $save_name);
            // $photo->move($photos_path. '/'.$s2_dir.'/', $save_name);
        //縮圖3  800
        Image::make($photo)
            ->resize($s3_dir, $ss3_dir, function ($constraints) {
                $constraints->aspectRatio();
            })
            ->save($photos_path . '/800/' . $save_name);
            // $photo->move($photos_path. '/'.$s3_dir.'/', $save_name);
        //
        $photo->move($photos_path, $save_name);
        //
        $photo_info =null;
        if($photo_record >0){
            $photo_info =HotelServicePhotos::where('hotel_list_id',$hotel_id)->where('hotel_service_id',$service_id)->first();
        }else{
            $photo_info =new HotelServicePhotos;
        }
        $photo_info->hotel_service_id =$service_id;
        $photo_info->hotel_list_id =$hotel_id;
        $photo_info->creator_id =$created_id;
        $photo_info->creator_name =$created_name;
        $photo_info->photo =$save_name;
        if($photo_record >0){
            $photo_info->update();
        }else{
            $photo_info->save();
        }
        // echo $service_id.'<br/>';
        // echo $hotel_id.'<br/>';
        // echo $created_id.'<br/>';
        // echo $created_name.'<br/>';
        // echo $save_name.'<br/>';
        //
        // return redirect()->back();
        return redirect()->to("/tw/auth/h".$hotel_id."/service_photo/".$service_id);
    }
}
