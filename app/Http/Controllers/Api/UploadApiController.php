<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Awugo\Picture;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use View;
use DB;
use Validator;
use Debugbar;
use Carbon;

class UploadApiController extends Controller
{
	private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/photos');
    }
	public function imageUploadView($country){
		return view('upload_temp');
	}
	//上傳圖片處理
    public function imageUpload(Request $request, $country){
    	// $request = request()->all();
    	ini_set('memory_limit', '256M');
    	//
    	$hotel_id =substr(session()->get('hotel_id'),1);
    	$created_id=session()->get('hotel_manager_id');
    	$created_name=session()->get('hotel_manager_name');
    	//
    	$photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $width = 0;
			$height = 0;
            list($width, $height) = getimagesize($photo);
            
			
            // $name = sha1(date('YmdHis') . str_random(30));
            $name =date("YmdHis").'_'.$hotel_id.'_'.(explode(' ', microtime())[0]*100000000);
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
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
                ->save($this->photos_path . '/100/' . $save_name);
                // $photo->move($this->photos_path. '/'.$s1_dir.'/', $save_name);
            //縮圖2  250
            Image::make($photo)
                ->resize($s2_dir, $ss2_dir, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->photos_path . '/250/' . $save_name);
                // $photo->move($this->photos_path. '/'.$s2_dir.'/', $save_name);
            //縮圖3  800
            Image::make($photo)
                ->resize($s3_dir, $ss3_dir, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->photos_path . '/800/' . $save_name);
                // $photo->move($this->photos_path. '/'.$s3_dir.'/', $save_name);
            //
            $photo->move($this->photos_path, $save_name);
            // Debugbar::info('s1'.$s1_dir.',ss1'.$ss1_dir);
            // Debugbar::info('s2'.$s2_dir.',ss2'.$ss2_dir);
            // Debugbar::info('s3'.$s3_dir.',ss3'.$ss3_dir);
            $picture = new Picture();
            $picture->name = $name;
            $picture->picture_type = $sub_name;
            $picture->hotel_list_id = $hotel_id;
            $picture->sort = 0;
            $picture->created_id = $created_id;
            $picture->created_name = $created_name;
            $picture->save();
        }
        return response()->json([
            'message' => '上傳成功'
        ], 200);
    }
    public function test(Request $request, $country){
        $test1 =HotelManagers::truncate();
        $test2 =Hotel::truncate();
        return '01';
    }
}
