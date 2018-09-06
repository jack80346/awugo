<?php

namespace App\Awugo\Auth;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //資料表
    protected $table ='hotel_list';
    //主鍵
    protected $primaryKey = 'nokey';
    /**
     * The attributes that are mass assignable.
     * 可大量異動的欄位
     * @var array
     */
    protected $fillable = [
        'contract_no','name', 'url', 'area_level1', 'area_level2', 'area_level3', 'area_level4', 'address', 'mapx', 'mapy',
        'tel1', 'tel2', 'fax1', 'fax2', 'email1','email2','app_line','app_wechat','license_hotel',
        'license_homestay','lincense_hospitable', 'illegal_homestay','type_scale','type_level','type_room','invoice',
        'reg_name','reg_no','credit_card','bank_name','bank_code','bank_account',
        'bank_account_name','point', 'introduction', 'traffic_info','version','state','deposit','control','fees_c','fees_c_bonus',
        'fees_ab','fees_ab_bonus','fees_d','fees_d_bonus','fees_sale','fees_sale_bonus','fees_roll',
        'fees_roll_bonus','track','track_comm','checkout','invoice_type','coordinate',
        'local_police','local_police_comm','seo_title','seo_descript','seo_keyword','contact_name',
        'contact_job','contact_tel','contact_mobile','contact_line','contact_wechat',
        'contact_email', 'contact_text','display_tel','manage_url','manage_surl','c_url','c_surl','d_url','d_surl',
        'd_enable','ab_url','login_name','login_com','login_job','login_tel','login_mobile',
        'login_email','login_id','login_passwd','login_addr_level1','login_addr_level2',
        'login_addr_level3','login_addr_level4','login_is_group','login_group_name',
        'login_group_url','login_group_count','expire', 'booking_day', 'cooperation', 'd_display_tel', 'sort', 'holiday', 'notice', 'created_manager_id', 'created_manager_name',
    ];

    public function getManager(){
        return $this->hasMany('App\Awugo\Auth\HotelManagers');
    }

    // *
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
     
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
