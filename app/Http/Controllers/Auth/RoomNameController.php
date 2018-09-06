<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Room_Name;
use App\Awugo\Auth\Areas;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use Request;
use Image;
use View;
use DB;
use Validator;

class RoomNameController extends Controller
{
    private $menu_item_code =48;
    private $menu_item_text ='客房設施／房型名稱';
    // private $auth_array =explode(',', session()->get('manager_auth'));
// 服務管理預設清單
    public function main(Request $request,$country){
        $auth_key =52; //
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return redirect('/'. $country .'/auth/manager/main')->withErrors($errors)->withInput();
            //exit;
        }
        //
        $page_row = 20;
        //
        $Room_Name_Items =Room_Name::OrderBy('room_name_list.sort','desc')->OrderBy('room_name_list.nokey','desc')->paginate($page_row);
        //ORM test
        // $tt =Room_Installation::where(function($query){
        //     $query->where('nokey','>',0)->where('is_group',1);
        // })->orWhere(function($query){
        //     $query->where('nokey','>',1)->where('is_group',0);
        // })->get();
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Room_Name_Items' => $Room_Name_Items,
        ];
        return view('auth.room_name_list', $binding);
    }
// 新增服務 ajax
    public function addPost(Request $request,$country){
        $auth_key =53; //
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return 'no';
            //exit;
        }
        $request =request()->all();
        //
        $service =new Room_Name;
        $service->name = $request['name'];
        $service->upload = (!empty($request['upload']))?$request['upload']:'0';
        $service->sort = $request['sort'];
        $service->created_id = session()->get('manager_id');
        $service->created_name = session()->get('manager_name');
        $service->save();

        return 'ok';
    }
// 編輯服務 
    public function editPost(Request $request,$country){
        $auth_key =54; //
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //功能按鈕編號  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return 'no';
            //exit;
        }
        $request =request()->all();
        //
        $service =Room_Name::where('nokey',$request['nokey'])->firstOrFail();
        $service->name = $request['name'];
        $service->upload = (!empty($request['upload']))?$request['upload']:'0';
        $service->sort = $request['sort'];
        $service->save();

        return 'ok';
    }
// 刪除服務 
    public function delPost(Request $request,$country){
        $auth_key =55; //權限碼
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return 'no';
            //exit;
        }
        $request =request()->all();
        //
        $service =Room_Name::where('nokey',$request['nokey'])->firstOrFail();

        $service->delete();

        return 'ok';
    }
}
