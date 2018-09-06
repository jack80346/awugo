<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelPriceInfo extends Model
{
    //資料表
    protected $table ='price_info';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'room_id', 'booking_percent', 'sale_percent', 'sale', 'checkin1', 'checkin2', 'checkout1', 'checkout2', 'food', 'pet_price', 'pet_place', 'pet_allow', 'pet_comm', 'extra_allow', 'extra_people', 'extra_bed', 'extra_comm', 'pickup_service', 'pickup_comm', 'pickup_booking', 'pickup_point', 'pickup_comm_extra', 'comm', 'creator_id', 'creator_name',
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
