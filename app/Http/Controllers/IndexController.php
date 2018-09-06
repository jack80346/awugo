<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Image;
use View;

class IndexController extends Controller
{
    public function main(){
    	return view('welcome');
    }
}
