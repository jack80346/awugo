<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    //資料表
    protected $table ='area_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'area_name', 'area_parent', 'area_level', 'area_code', 'zip_code',
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
