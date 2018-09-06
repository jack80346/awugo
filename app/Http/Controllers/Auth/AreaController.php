<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Areas;
use Image;
use View;
use DB;
use Validator;

class AreaController extends Controller
{
    private $menu_item_code =43;
    private $menu_item_text ='地區管理設定';
    // private $auth_array =explode(',', session()->get('manager_auth'));
// 地區管理預設清單
    public function main($country){
        //
        $auth_array =explode(',', session()->get('manager_auth'));
        //
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        //
        $Countries =Areas::where('area_level','1')->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $Areas_level2 =Areas::where('area_level','2')->where('area_parent', '=', $Countries->toArray()[0]['nokey'])->get(); //二級區域
        // echo $Countries->toArray()[0]['noekey'];
        // exit;
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Countries' => $Countries,
            'Areas_level2' => $Areas_level2,
        ];
        return view('auth.area_list', $binding);
    }
// 取得郵遞區號
    public function getZipCode(){
        $request =request()->all();
        $nokey =$request['nokey'];
        //
        return Areas::where('nokey',$nokey)->get(['zip_code'])->toArray();
    }
// 取得子區域
    public function getSubArea(){
        $request =request()->all();
        $level =$request['level'];
        //
        return Areas::where('area_parent',$level)->get()->toArray();
    }
// 地區新增介面
    public function add(){
        $auth_key ='40'; //
        //var_dump($auth_array);
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return redirect('/auth/manager/area_list')->withErrors($errors)->withInput();
            //exit;
        }
        
        return "新增地區";
    }
// 地區新增POST
    public function addArea(){
        $request =request()->all();
        $area_level =$request['level_no'];
        $area_parent =$request['parent_no'];
        $area_name =$request['area_string'];
        $area =new Areas;
        $area->area_name =$area_name;
        $area->area_parent =$area_parent;
        $area->area_level =$area_level;
        $area->save();
        return "ok";
    }
// 地區修改介面
    public function edit($area_nokey){
        // DB::enableQueryLog();
        $auth_key ='41'; //
        //var_dump($auth_array);
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //  
                'Manager' => $Manager,
            ];
            return redirect('/auth/manager/area_list')->withErrors($errors)->withInput();
            //exit;
        }
        
    	return "地區編輯";
    }
// 地區修改POST
    public function editArea($area_nokey){
        // DB::enableQueryLog();
        $request =request()->all();
        $area_nokey1 =$request['req_nokey'];
        $area_name =$request['req_name'];
        $zip_code=$request['zip_code'];
        $area =Areas::where('nokey',$area_nokey1)->first();
        $area->area_name =$area_name;
        $area->zip_code =$zip_code;
        $area->save();
        // exit;
        return "編輯完成";
    }

// (清單)刪除地區 Ajax
    public function delArea($area_key){
        $request =request()->all();
        $area_nokey =$request['req_nokey'];
        $area =Areas::where('nokey',$area_nokey)->first();
        $area->delete();
        // exit;
        return "刪除完成";
    }
}
