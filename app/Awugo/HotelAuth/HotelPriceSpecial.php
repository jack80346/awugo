<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelPriceSpecial extends Model
{
    //資料表
    protected $table ='price_special';
    //主鍵
    protected $primaryKey = 'nokey';
    
    protected $guarded = [];


    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
    // 
}
