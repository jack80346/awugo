<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelRoomSet extends Model
{
    //資料表
    protected $table ='hotel_room_set';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'name', 'bed', 'min_people', 'max_people', 'room_count', 'room_open_count', 'room_area', 'room_feature', 'room_device', 'room_type', 'creator_id', 'creator_name', 'updated_at', 'created_at', 
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
