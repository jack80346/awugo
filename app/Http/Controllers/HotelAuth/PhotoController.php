<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Hotel;
use App\Awugo\HotelAuth\Picture;
use Request;
use Image;
use View;
use DB;
use Validator;
use Debugbar;
use Carbon;
use File;

class PhotoController extends Controller
{
	// 照片上傳介面
    public function main($country, $hotel_id){
        $Category =Request::input('cate');
        // exit;
        $Manager =HotelManagers::where('id',session()->get('hotel_manager_id'))->firstOrFail()->toArray();
        // 取出照片
        if($Category !=''){
            $Photos =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',$Category)->Orderby('sort','desc')->Orderby('updated_at')->get();
        }else{
            $Photos =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->Orderby('sort','desc')->Orderby('updated_at')->get();
        }
        
        // 取得設施環境數量
        $Photo_count[0] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',1)->count();
        // 取得餐飲數量
        $Photo_count[1] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',2)->count();
        // 取得溫泉數量
        $Photo_count[2] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',3)->count();
        // 取得客房數量
        $Photo_count[3] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',4)->count();
        // 取得其他數量
        $Photo_count[4] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->where('category',-1)->count();
        // 取得所有照片數量
        $Photo_count[5] =Picture::where('hotel_list_id',substr(session()->get('hotel_id'),1))->count();
        // 取出飯店檔案
        $Hotel =Hotel::find(substr($hotel_id, 1));
        //切分帳號權限
        $auth_array =explode(',', session()->get('hotel_manager_auth'));
        $binding =[
            'Title' => '照片上傳',
            'Nav_ID' => 10,  //功能按鈕編號  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Hotel_ID' => $hotel_id,
            'Country' => $country,
            'Hotel' =>$Hotel,
            'Photos' =>$Photos,
            'Category' =>$Category,
            'Category_Counts' =>$Photo_count,
        ];
    	return view('hotel_auth.upload_photo', $binding);
    }
    //上傳照片平台
    public function plan($country, $hotel_id){
        app('debugbar')->disable();
        return view('hotel_auth.upload_photo_plan');
    }
    // 上傳照片POST
    public function mainPost($country, $hotel_id){
        
    }
    // 照片刪除
    public function delPic($country, $hotel_id){
        $request =request()->all();
        $Photos = Picture::find($request['nokey']);
        $file_name =$Photos->name.'.'.$Photos->picture_type;
        $photos_path1 = public_path('/photos/100/'.$file_name);
        $photos_path2 = public_path('/photos/250/'.$file_name);
        $photos_path3 = public_path('/photos/800/'.$file_name);
        $photos_path4 = public_path('/photos/'.$file_name);
        $del_photos =array($photos_path1,$photos_path2,$photos_path3,$photos_path4);
        File::delete($del_photos);
        $Photos->delete();
        return 1;
    }
    // 照片獨立修改介面
    public function editPlan($country, $hotel_id){
        app('debugbar')->disable();
        $photo_id =Request::input('id');
        $request =request()->all();
        $Photo = Picture::where('nokey',$photo_id)->where('hotel_list_id',substr($hotel_id,1))->firstOrFail();
        $binding =[
            'Photo' => $Photo,
        ];
        return view('hotel_auth.edit_photo_plan',$binding);
    }
    // 照片資訊修改
    public function editPic($country, $hotel_id){
        $request =request()->all();
        $Photos = Picture::find($request['nokey']);
        $Photos->title =$request['title'];
        $Photos->sort =$request['sort'];
        $Photos->save();

        return 1;
    }
    // 照片分類修改
    public function changeCate($country, $hotel_id){
        $request =request()->all();
        $Photos = Picture::find($request['nokey']);
        $Photos->category =$request['cate'];
        $Photos->save();

        return 1;
    }
}
