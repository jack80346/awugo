<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class HotelBedList extends Model
{
    //資料表
    protected $table ='hotel_bed_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'room_id', 'bed_id', 'count', 'creator_id', 'creator_name', 
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
