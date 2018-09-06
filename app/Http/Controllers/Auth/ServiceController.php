<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Service;
use App\Awugo\Auth\Areas;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use Request;
use Image;
use View;
use DB;
use Validator;

class ServiceController extends Controller
{
    private $menu_item_code =44;
    private $menu_item_text ='設施與服務';
// 服務管理預設清單
    public function main(Request $request,$country){
        $auth_key =$this->menu_item_code; //
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

        $page_row = 30;

        //
        $group_q =Request::input('group');            //
        $group_s1 =($group_q !='-1')?$group_q:'%';
        $group_s2 =($group_q =='-2')?'-1':'%';         //
        $group_s3 =($group_q =='-3')?'-1':'%';         //
        $queryString =['group'=>$group_q];
        //讀取設施與服務(群組)
        $Service_Groups =Service::where('service_list.is_group','1')->select('service_list.*',DB::raw('(SELECT count(sl.`nokey`) FROM `service_list` as sl WHERE sl.`parent`=`service_list`.`nokey`) as `child_count`'))->get();
        //讀取設施與服務(項目)

        $Service_Items ='';
        if($group_q =='-2' || $group_q =='-3'){
            $Service_Items =Service::where('service_list.parent','LIKE',$group_s2)->leftjoin('service_list as sl','sl.nokey', '=', 'service_list.parent')->select('service_list.*', 'sl.service_name as sl_name')->OrderBy('service_list.parent','desc')->OrderBy('service_list.sort','desc')->paginate($page_row)->appends($queryString);
        }else{
            $Service_Items =Service::where('service_list.parent','LIKE',$group_s1)->orWhere('service_list.nokey','LIKE',$group_s1)->leftjoin('service_list as sl','sl.nokey', '=', 'service_list.parent')->select('service_list.*', 'sl.service_name as sl_name')->OrderBy('service_list.parent','desc')->OrderBy('service_list.sort','desc')->paginate($page_row)->appends($queryString);
        }

        //
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Service_Groups' => $Service_Groups,
            'Service_Items' => $Service_Items,
            'Group_Query' => $group_q,
        ];
        return view('auth.service_list', $binding);
    }
// 新增服務 ajax
    public function addPost(Request $request,$country){
        $auth_key =45; //
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
        $service =new Service;
        $service->service_name = $request['name'];
        //
        $request['parent']=(!empty($request['parent']))?$request['parent']:'-1';  
        $request['parent']=($request['parent']=='-2')?'-1':$request['parent'];
        $is_group=0;
        if($request['parent']=='-1'){
            $is_group=1;
        }
        $service->parent = $request['parent'];
        if($request['parent']=='-1'){
            $service->sort =0;
        }
        $service->upload = (!empty($request['upload']))?$request['upload']:0;
        $service->is_group = $is_group;
        $service->created_id = session()->get('manager_id');
        $service->created_name = session()->get('manager_name');
        $service->save();

        return 'ok';
    }
// 編輯服務 
    public function editPost(Request $request,$country){
        $auth_key =46; //
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
        $service =Service::where('nokey',$request['nokey'])->firstOrFail();
        $service->service_name = $request['name'];
        $service->upload = $request['upload'];
        $service->sort = $request['sort'];
        $service->save();

        return 'ok';
    }
// 刪除服務 
    public function delPost(Request $request,$country){
        $auth_key =47; //
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
            $service =Service::where('nokey',$request['nokey'])->orWhere('parent',$request['nokey']);
        }else{
            $service =Service::where('nokey',$request['nokey'])->firstOrFail();
        }

        $service->delete();

        return 'ok';
    }
}
