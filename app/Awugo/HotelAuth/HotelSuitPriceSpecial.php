<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelSuitPriceSpecial extends Model
{
    //資料表
    protected $table ='suit_price_special';
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
