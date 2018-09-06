<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Managers extends Model
{
    //資料表
    protected $table ='manager_list';
    //主鍵
    protected $primaryKey = 'nokey';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'id','passwd', 'name', 'department', 'auth' ,
    ];

    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
