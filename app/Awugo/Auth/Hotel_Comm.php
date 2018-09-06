<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Hotel_Comm extends Model
{
    //資料表
    protected $table ='hotel_comm_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'comm', 'write_id', 'write_name',
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
