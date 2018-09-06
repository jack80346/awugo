<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Room_Installation;
use App\Awugo\Auth\Areas;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use Request;
use Image;
use View;
use DB;
use Validator;

class RoomInstallationController extends Controller
{
    private $menu_item_code =48;
    private $menu_item_text ='客房設施';
    // private $auth_array =explode(',', session()->get('manager_auth'));
// 服務管理預設清單
    public function main(Request $request,$country){
        $auth_key =$this->menu_item_code; //權限碼
        //讀取管理者資訊
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
            return redirect('/'. $country .'/auth/manager/hotel_list')->withErrors($errors)->withInput();
            //exit;
        }
        //
        $page_row = 20;
        //
        $group_q =Request::input('group');            //
        $group_s1 =($group_q !='-1')?$group_q:'%';
        $group_s2 =($group_q =='-2')?'-1':'%';         //
        $queryString =['group'=>$group_q];
        //
        $Room_Installation_Groups =Room_Installation::where('room_installation_list.is_group','1')->select('room_installation_list.*',DB::raw('(SELECT count(sl.`nokey`) FROM `room_installation_list` as sl WHERE sl.`parent`=`room_installation_list`.`nokey`) as `child_count`'))->get();
        //
        $Room_Installation_Items ='';
        if($group_q =='-2'){
            $Room_Installation_Items =Room_Installation::where('room_installation_list.parent','LIKE',$group_s2)->leftjoin('room_installation_list as sl','sl.nokey', '=', 'room_installation_list.parent')->select('room_installation_list.*', 'sl.service_name as sl_name')->OrderBy('room_installation_list.parent','desc')->paginate($page_row)->appends($queryString);
        }else{
            $Room_Installation_Items =Room_Installation::where('room_installation_list.parent','LIKE',$group_s1)->orWhere('room_installation_list.nokey','LIKE',$group_s1)->leftjoin('room_installation_list as sl','sl.nokey', '=', 'room_installation_list.parent')->select('room_installation_list.*', 'sl.service_name as sl_name')->OrderBy('room_installation_list.parent','desc')->paginate($page_row)->appends($queryString);
        }
        //ORM test
        // $tt =Room_Installation::where(function($query){
        //     $query->where('nokey','>',0)->where('is_group',1);
        // })->orWhere(function($query){
        //     $query->where('nokey','>',1)->where('is_group',0);
        // })->get();
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //功能按鈕編號  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Room_Installation_Groups' => $Room_Installation_Groups,
            'Room_Installation_Items' => $Room_Installation_Items,
            'Group_Query' => $group_q,
        ];
        return view('auth.room_installation_list', $binding);
    }
// 新增服務 ajax
    public function addPost(Request $request,$country){
        $auth_key =49; //
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
        $service =new Room_Installation;
        $service->service_name = $request['name'];
        //C版手續費
        $request['parent']=(!empty($request['parent']))?$request['parent']:'-1';  
        $is_group=0;
        if($request['parent']=='-1'){
            $is_group=1;
        }
        $service->parent = $request['parent'];
        $service->is_group = $is_group;
        $service->upload = (!empty($request['upload']))?$request['upload']:'0';
        $service->created_id = session()->get('manager_id');
        $service->created_name = session()->get('manager_name');
        $service->save();

        return 'ok';
    }
// 編輯服務 ajax
    public function editPost(Request $request,$country){
        $auth_key =50; //
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
        $service =Room_Installation::where('nokey',$request['nokey'])->firstOrFail();
        $service->service_name = $request['name'];
        $service->upload = (!empty($request['upload']))?$request['upload']:'0';
        $service->save();

        return 'ok';
    }
// 刪除服務 ajax
    public function delPost(Request $request,$country){
        $auth_key =51; //
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
        $is_group =($request['group'])?1:0;
        $service =null;
        if($is_group){
            $service =Room_Installation::where('nokey',$request['nokey'])->orWhere('parent',$request['nokey']);
        }else{
            $service =Room_Installation::where('nokey',$request['nokey'])->firstOrFail();
        }

        $service->delete();

        return 'ok';
    }
}
