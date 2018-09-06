<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class HotelManagers extends Model
{
    //資料表
    protected $table ='hotel_manager_list';
    //主鍵
    protected $primaryKey = 'nokey';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'id', 'hotel_list_id','passwd', 'name', 'department', 'auth', 'ip', 'created_name', 'created_id' ,
    ];

    

    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
