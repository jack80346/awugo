<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Room_Installation extends Model
{
    //資料表
    protected $table ='room_installation_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'service_name', 'upload', 'is_group', 'parent', 'created_id','created_name',
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
