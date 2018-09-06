<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Awugo\Auth\Areas;
use Image;
use View;
use DB;
use Validator;

class AreaApiController extends Controller
{
	//取得國家
    public function getArea1(){
    	$areas =Areas::where('area_parent','0')->get()->toJSON();
    	return $areas;
    }
    //取得縣市
    public function getArea2($country, $in_country){
    	$areas =Areas::where('area_parent',$in_country)->get()->toJSON();
    	return $areas;
    }
    //取得行政區
    public function getArea3($country, $parent){
    	$areas =Areas::where('area_parent',$parent)->get()->toJSON();
    	return $areas;
    }
    //取得行政區蛋黃區
    public function getArea4($country, $parent){
    	$areas =Areas::where('area_parent',$parent)->get()->toJSON();
    	return $areas;
    }
    //取得郵遞區號
    public function getZipCode($country, $area_key){
    	$areas =Areas::where('nokey',$area_key)->get(['zip_code'])->toJSON();
    	return $areas;
    }
}
