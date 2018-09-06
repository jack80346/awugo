<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\HotelManagers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cookie;
use Image;
use View;
use DB;
use Validator;


class SignController extends Controller
{
	// 
    public function login($country, $hotel_id){
        // $request =request()->all();
        // Cookie::forever('country', 'tw');
        // $cookies = $request->cookie();
        // dump($cookies) ;
        // abort(404);
        // echo $hotel_id;
        // exit;
        if(!is_null(session()->get('manager_id')) && !is_null(session()->get('manager_name'))){
        //
            session()->put('hotel_manager_id', session()->get('manager_id'));
            session()->put('hotel_manager_nokey', session()->get('manager_nokey'));
            session()->put('hotel_manager_name', session()->get('manager_name'));
            session()->put('hotel_manager_auth', '');
            session()->put('hotel_country', session()->get('manager_country'));
            session()->put('hotel_id', $hotel_id);
            return redirect()->to('/'. session()->get('manager_country') .'/auth/'.$hotel_id.'/main');
        }
        //
        $binding =[
            'Hotel_ID' => $hotel_id,
        ];
    	return view('hotel_auth/login', $binding);
    }
    // 
    public function login_post($country, $hotel_id){
        // DB::enableQueryLog();
        // exit;
    	$input = request()->all();
        // 
        $rules =[
            //
            'inputID'=>[
                'required',
                'min:3',
            ],
            //
            'inputPassword'=>[
                'required',
                'min:3',
            ],
        ];
        // 
        $validator =Validator::make($input, $rules);
        //
        if($validator->fails()){
            return redirect('/'. $country .'/auth/'.$hotel_id)->withErrors($validator)->withInput();
        }
        // 
        // $input['inputPassword'] = Hash::make($input['inputPassword']);
        try {
          $Manager =HotelManagers::where('id',$input['inputID'])->where('hotel_list_id',substr($hotel_id, 1))->where('enable',1)->firstOrFail()->toArray();
            //
            $Manager['if_manager'] =Hash::check($input['inputPassword'], $Manager['passwd']);
            if($Manager['if_manager'] && $Manager['enable']=='1'){
                // 
                $Manager_update =HotelManagers::where('id',$input['inputID'])->firstOrFail();
                $Manager_update->updated_at =date ("Y-m-d H:i:s");
                $Manager_update->save();
                //
                session()->put('hotel_manager_id', $input['inputID']);
                session()->put('hotel_manager_nokey', $Manager['nokey']);
                session()->put('hotel_manager_name', $Manager['name']);
                session()->put('hotel_manager_auth', $Manager['auth']);
                session()->put('hotel_country', $country);
                session()->put('hotel_id', $hotel_id);
                // exit;
            }else{
                throw (new ModelNotFoundException);
            }
        } catch (ModelNotFoundException $ex) {
            $validator =['無此帳號或帳號密碼錯誤'];
            return redirect('/'. $country .'/auth/'.$hotel_id)->withErrors($validator)->withInput();
        }
        
        //session()->flush();
        // 
        //echo Hash::make($input['inputPassword']);
        // var_dump($Manager);
        // exit;
        //var_dump(DB::getQueryLog());
        // $binding =[
        //     'Title' => '主頁',
        //     'Nav_ID' => 4,  //功能按鈕編號  
        //     'Manager' => $Manager,
        // ];
        
    	return redirect()->to('/'. $country .'/auth/'.$hotel_id.'/main');
    	// return var_dump(DB::getQueryLog());
    }
    // 
    public function logout($country,$hotel_id){
        session()->flush();
        
        session()->put('hotel_country', $country);
        session()->put('manager_country', $country);
    	return redirect()->to('/'. $country .'/auth/'.$hotel_id);
    }
}
