<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Areas;
use Image;
use View;
use DB;

class ManagerController extends Controller
{
	// 飯店管理基本資料
    public function main($country, $hotel_id){
        // exit;
        $Manager =HotelManagers::where('id',session()->get('hotel_manager_id'))->firstOrFail()->toArray();
        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));
        //
        $Areas_level2 =Areas::where('area_level','2')->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $Addr_level3 =Areas::where('area_parent',$Hotel->area_level2)->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $auth_array =explode(',', session()->get('hotel_manager_auth'));
        $binding =[
            'Title' => '最新消息',
            'Nav_ID' => 10,  //功能按鈕編號  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Hotel_ID' => $hotel_id,
            'Country' => $country,
            'Hotel' =>$Hotel,
            'Areas_level2' => $Areas_level2,
            'Addr_level3' => $Addr_level3,
            'Login_addr_level3' => $Addr_level3,
        ];
    	return view('hotel_auth.main', $binding);
    }
    // 飯店管理基本資料POST
    public function mainPost($country, $hotel_id){
        $request =request()->all();
        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));
        $Hotel->name =$request['name'];
        //
        $Hotel->license_hotel=(!empty($request['license_hotel']))?$request['license_hotel']:0;
        //
        $Hotel->license_homestay=(!empty($request['license_homestay']))?$request['license_homestay']:0;
        //
        $Hotel->license_hospitable=(!empty($request['license_hospitable']))?$request['license_hospitable']:0;         
        $Hotel->url =$request['url'];
        $Hotel->type_scale =$request['type_scale'];
        $Hotel->type_level =$request['type_level'];
        $Hotel->type_room =$request['type_room'];
        $Hotel->area_level2 =$request['area_level2'];
        $Hotel->area_level3 =$request['area_level3'];
        $Hotel->zip_code =$request['zip_code'];
        $Hotel->address =$request['address'];
        $Hotel->invoice =$request['invoice'];
        $Hotel->tel1 =$request['tel1'];
        $Hotel->tel2 =$request['tel2'];
        $Hotel->fax1 =$request['fax1'];
        $Hotel->fax2 =$request['fax2'];
        $Hotel->reg_name =$request['reg_name'];
        $Hotel->reg_no =$request['reg_no'];
        $Hotel->email1 =$request['email1'];
        $Hotel->email2 =$request['email2'];
        $Hotel->credit_card =$request['credit_card'];
        $Hotel->app_line =$request['app_line'];
        $Hotel->app_wechat =$request['app_wechat'];
        $Hotel->bank_name =$request['bank_name'];
        $Hotel->bank_code =$request['bank_code'];
        $Hotel->bank_account =$request['bank_account'];
        $Hotel->bank_account_name =$request['bank_account_name'];
        $Hotel->point =$request['point'];
        $Hotel->introduction =$request['introduction'];
        $Hotel->traffic_info =$request['traffic_info'];
        $Hotel->mapx =$request['mapx'];
        $Hotel->mapy =$request['mapy'];
        $Hotel->notice =$request['notice'];

        $Hotel->save();

        return redirect()->to('/'. session()->get('hotel_country') .'/auth/'. session()->get('hotel_id') .'/main')->with('controll_back_msg', 'ok');
    }
}
