<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\HotelAuthority;
use App\Awugo\Auth\HotelManagers;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use Request as UseRequest;
use Image;
use View;
use DB;
use Validator;

class HotelAuthController extends Controller
{
    private $menu_item_code =1;
    private $menu_item_text ='飯店人員權限管理';

    public function main(Request $request,$country,$hotel_key)
    {
        //
        $manager_list =HotelManagers::where('hotel_list_id',$hotel_key)->paginate(30);
        //
        $hotel_profile =Hotel::find($hotel_key);
        //
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Managers' => $manager_list,
            'Auths' => $auth_array,
            'Country' => $country,
            'Hotel' => $hotel_profile,
        ];
        return view('auth.hotel_manager_list', $binding);
    }
    //新增管理員
    public function add(Request $request,$country,$hotel_key){
        //
        $manager_list =HotelManagers::where('hotel_list_id',$hotel_key)->paginate(30);
        //
        $hotel_profile =Hotel::find($hotel_key);
        //
        //
        $Authority_root =HotelAuthority::where('auth_parent','-1')->get();
        //
        $Authority_sub =HotelAuthority::where('auth_parent','<>',"-1")->get();
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Managers' => $manager_list,
            'Auths' => $auth_array,
            'Country' => $country,
            'Hotel' => $hotel_profile,
            'Auth_root' => $Authority_root,
            'Auth_sub' => $Authority_sub,
        ];
        return view('auth.hotel_manager_add', $binding);
    }
// 權限管理員新增POST
    public function addPost(Request $request,$country,$hotel_key){
        // DB::enableQueryLog();

        $request =request()->all();
        //
        $rules =[
            //
            'inputID'=>[
                'required',
                'min:3',
            ],
            //
            'exampleInputPassword1'=>[
                'required',
                'same:exampleInputPassword2',
                'min:3',
            ],
            //
            'inputUserID'=>[
                'required',
                'min:2',
            ],
            //
            'inputDepartment'=>[
                'required',
                'min:2',
            ],
        ];
        // 
        $validator =Validator::make($request, $rules);
        //
        if($validator->fails()){
            return redirect('/'. $country .'/auth/manager/hotel_auth_add/'.$hotel_key)->withErrors($validator)->withInput();
        }

        $Manager = new HotelManagers;

        //
        if(!isset($request['auth_chk'])){
            $request['auth_chk'] ="";
            $Manager->auth =$request['auth_chk'];
        }else{
            $Manager->auth =implode(',',$request['auth_chk']);
        }
        $Manager->id = $request['inputID'];
        $Manager->name = $request['inputUserID'];
        $Manager->passwd = Hash::make($request['exampleInputPassword1']);
        $Manager->department = $request['inputDepartment'];
        $mEnable=0;
        if(isset($request['enableAccount'])){
            $mEnable=1;
        }
        $Manager->enable = $mEnable;   
        $Manager->hotel_list_id=$hotel_key;
        $Manager->ip=UseRequest::ip();
        $Manager->created_id=session()->get('manager_id');
        $Manager->created_name=session()->get('manager_name').'/awugo';

        $Manager->save();
        // exit;
        return redirect()->to('/'. $country .'/auth/manager/hotel_auth_list/'.$hotel_key)->with('controll_back_msg', 'ok');
    }
    //編輯管理員
    public function edit(Request $request,$country,$hotel_key,$mem_key){
        // DB::enableQueryLog();
        //
        $h_auth =HotelManagers::find($mem_key)->get(['nokey'])->toArray();
        $auth_string='';
        //
        foreach($h_auth as $auth){
            $auth_string .=$auth['nokey'].',';
        }
        $auth_string =substr($auth_string,0,-1);                     //
        $auth_array =explode(',', session()->get('manager_auth'));
        //
        $Authority_root =HotelAuthority::where('auth_parent','-1')->get();
        //
        $Authority_sub =HotelAuthority::where('auth_parent','<>',"-1")->get();
        //
        $Manager =HotelManagers::where('nokey',$mem_key)->firstOrFail();
        $Manager_auth =explode(',', $Manager->auth);
        // var_dump(DB::getQueryLog());
        // print_r($Authority_sub);

        // exit;
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //功能按鈕編號  
            'Auth_root' => $Authority_root,
            'Auth_sub' => $Authority_sub,
            'Manager_auth' => $Manager_auth,
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
        ];
        return view('auth.hotel_manager_edit', $binding);
    }
    //編輯管理員  POST
    public function editPost(Request $request,$country,$hotel_key,$mem_key){
        // DB::enableQueryLog();
        $request =request()->all();
        //
        $rules =[
            //
            'exampleInputPassword1'=>[
                'required',
                'same:exampleInputPassword2',
                'min:3',
            ],
            //
            'inputUserID'=>[
                'required',
                'min:2',
            ],
            //
            'inputDepartment'=>[
                'required',
                'min:2',
            ],
        ];
        // 
        if(!isset($request['editPW'])){
            unset($rules['exampleInputPassword1']);
        }
        // 
        $validator =Validator::make($request, $rules);
        //
        if($validator->fails()){
            return redirect('/'. $country .'/auth/manager/hotel_manager_edit/'.$mem_key)->withErrors($validator)->withInput();
        }
        $Manager =HotelManagers::where('nokey',$mem_key)->firstOrFail();
        //
        if(!isset($request['auth_chk'])){
            $request['auth_chk'] ="";
            $Manager->auth =$request['auth_chk'];
        }else{
            $Manager->auth =implode(',',$request['auth_chk']);
        }
        // 
        if(isset($request['editPW'])){
            $Manager->passwd = Hash::make($request['exampleInputPassword1']);
        }
        // $Manager->id = $request['inputID'];
        $Manager->name = $request['inputUserID'];
        $Manager->department = $request['inputDepartment'];
        $mEnable=0;
        if(isset($request['enableAccount'])){
            $mEnable=1;
        }
        $Manager->enable = $mEnable;   
        $Manager->ip=UseRequest::ip();
        $Manager->created_id=session()->get('manager_id');
        $Manager->created_name=session()->get('manager_name').'/awugo';
        $Manager->save();
        // exit;
        return redirect()->to('/'. $country .'/auth/manager/hotel_auth_list/'.$hotel_key)->with('controll_back_msg', 'ok');
    }
}
