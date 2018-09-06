<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use Image;
use View;
use DB;
use Validator;

class AuthorityController extends Controller
{
    private $menu_item_code =29;
    private $menu_item_text ='權限管理';
    // private $auth_array =explode(',', session()->get('manager_auth'));
// 權限管理員清單
    public function main($country){
        $auth_key ='33'; //
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
            return redirect('/'. $country .'/auth/manager/main')->withErrors($errors)->withInput();
            //exit;
        }
        // 每頁筆數
        $page_row =20;
        $Manager_pagerow =Managers::OrderBy('enable','desc')->OrderBy('nokey','desc')->paginate($page_row);

        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Managers' => $Manager_pagerow,
            'Auths' => $auth_array,
            'Country' => $country,
        ];
        return view('auth.authority_list', $binding);
    }
// 權限管理員新增頁
    public function add($country){
        $auth_key ='34'; //新增管理員權限碼
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
            return redirect('/'. $country .'/auth/manager/authority_list')->withErrors($errors)->withInput();
            //exit;
        }
        //
        $Authority_root =Authority::where('auth_parent','-1')->get();
        //
        $Authority_sub =Authority::where('auth_parent','<>',"-1")->get();
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  // 
            'Auth_root' => $Authority_root,
            'Auth_sub' => $Authority_sub,
            'Auths' => $auth_array,
            'Country' => $country,
        ];
        return view('auth.authority_add', $binding);
    }
// 權限管理員新增POST
    public function addAuth($country){
        // DB::enableQueryLog();

        $request =request()->all();
        //修改規則驗證
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
            return redirect('/'. $country .'/auth/manager/authority_add')->withErrors($validator)->withInput();
        }

        $Manager = new Managers;

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

        $Manager->save();
        // exit;
        return redirect()->to('/'. $country .'/auth/manager/authority_add')->with('controll_back_msg', 'ok');
    }
// 權限管理編輯頁
    public function edit($country, $manager_nokey){
        // DB::enableQueryLog();
        $auth_key ='35'; //
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
            return redirect('/'. $country .'/auth/manager/authority_list')->withErrors($errors)->withInput();
            //exit;
        }
        //
        $Authority_root =Authority::where('auth_parent','-1')->get();
        //
        $Authority_sub =Authority::where('auth_parent','<>',"-1")->get();
        //
        $Manager =Managers::where('nokey',$manager_nokey)->firstOrFail();
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
    	return view('auth.authority_edit', $binding);
    }
// 權限管理修改
    public function editAuth($country, $manager_nokey){
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
            return redirect('/'. $country .'/auth/manager/authority_edit/$manager_nokey')->withErrors($validator)->withInput();
        }
        $Manager =Managers::where('nokey',$manager_nokey)->firstOrFail();
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
        $Manager->save();
        // exit;
        return redirect()->to('/'. $country .'/auth/manager/authority_edit/'.$manager_nokey)->with('controll_back_msg', 'ok');
    }

// (清單)權限管理員啟動管理 Ajax
    public function enable($manager_key){
        $auth_key ='35'; //管理員編輯權限碼

        $request =request()->all();
        $enable =$request['enable'];
        $Manager =Managers::where('nokey',$manager_key)->firstOrFail();
        $Manager->enable =$enable;
        $Manager->save();
        return "管理員啟動管理--".$enable;
    }
}
