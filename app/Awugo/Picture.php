<?php

namespace App\Awugo;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //資料表
    protected $table ='picture_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'name', 'picture_type', 'hotel_list_id', 'title', 'description', 'sort', 'category', 'created_id', 'created_name', 'updated_at', 'created_at',
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
