<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelPriceNormal extends Model
{
    //資料表
    protected $table ='price_normal';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'room_id', 'merge', 'people', 'weekday', 'friday', 'saturday', 'sunday', 'is_year', 'start', 'end', 'creator_id', 'creator_name',
    ];


    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
    // 
}
