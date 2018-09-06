<?php

namespace App\Awugo\HotelAuth;

use Illuminate\Database\Eloquent\Model;

class HotelServicePhotos extends Model
{
    //資料表
    protected $table ='hotel_service_upload';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_service_id', 'hotel_list_id', 'photo', 'cost', 'period', 'comm', 'creator_id', 'creator_name',
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
