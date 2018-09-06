<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    //資料表
    protected $table ='manager_auth_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'auth_name', 'auth_token', 'auth_parent',
    ];

    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
