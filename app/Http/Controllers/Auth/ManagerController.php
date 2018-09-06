<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Managers;
use Image;
use View;
use DB;

class ManagerController extends Controller
{
	// 首頁儀錶板
    public function main($country){
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        //
        $auth_array =explode(',', session()->get('manager_auth'));
        $binding =[
            'Title' => '最新消息',
            'Nav_ID' => 10,  //功能按鈕編號  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
        ];
    	return view('auth.main', $binding);
    }
}
