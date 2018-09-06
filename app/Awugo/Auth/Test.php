<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //資料表
    protected $table ='test';
    //主鍵
    protected $primaryKey = 'index';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'tt',
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
