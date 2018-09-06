<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Awugo\Auth\Authority;
use App\Awugo\Auth\Managers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Hotel_Comm;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\HotelAuthority;
use App\Awugo\Auth\Areas;
use Carbon\Carbon;
use Request as RQ;
// use Illuminate\Http\Request;
use Request;
use Image;
use View;
use DB;
use Validator;

class HotelController extends Controller
{
    private $menu_item_code =1;
    private $menu_item_text ='飯店管理';
    // private $auth_array =explode(',', session()->get('manager_auth'));
// 
    public function main(Request $request,$country){
        //
        $state_q =Request::input('state');              
        $ver_q =Request::input('ver');                  
        $country_q =Request::input('country');          
        $legal_q =Request::input('legal');              
        $area2_q =Request::input('area2');              
        $area3_q =Request::input('area3');              
        $ctrl_q =Request::input('ctrl');                
        $c_type_q =Request::input('c_type');            
        $room_count_q =Request::input('room_count');    
        $holiday_q =Request::input('holiday');          
        $search_q =trim(Request::input('search'));      
        $queryString =['state'=>$state_q,'ver'=>$ver_q,'country'=>$country_q,'area2'=>$area2_q,'area3'=>$area3_q,'ctrl'=>$ctrl_q,'c_type'=>$c_type_q,'room_count'=>$room_count_q,'holiday'=>$holiday_q,'search'=>$search_q,'legal'=>$legal_q];
        //
        $state_s =($state_q==null ||$state_q=='-1')?'%':$state_q;                           
        $ver_s =($ver_q==null ||$ver_q=='-1')?'%':$ver_q;                                   
        $country_s =($country_q==null ||$country_q=='-1')?'%':$country_q;                   
        $illegal_s =($legal_q=='-1')?'%':$legal_q;                                          
        $illegal_s =($legal_q=='1')?'0':$illegal_s;
        $illegal_s =($legal_q=='2')?'1':$illegal_s;
        $area2_s =($area2_q==null ||$area2_q=='-1')?'%':$area2_q;                           
        $area3_s =($area3_q==null ||$area3_q=='-1')?'%':$area3_q;                           
        $ctrl_s =($ctrl_q==null ||$ctrl_q=='-1')?'%':$ctrl_q;                               
        $c_type_s =($c_type_q==null ||$c_type_q=='-1')?'%':$c_type_q;                       
        $holiday_s =($holiday_q==null ||$holiday_q=='-1')?'%':$holiday_q;                   
        $room_count_s =($room_count_q==null ||$room_count_q=='-1')?'%':$room_count_q;       
        //
        $room_arr =array();
        if($room_count_s =='100'){
            $room_arr=array(100,999);
        }else if($room_count_s =='50-99'){
            $room_arr=array(50,99);
        }else if($room_count_s =='15-49'){
            $room_arr=array(15,49);
        }else if($room_count_s =='1-14'){
            $room_arr=array(1,14);
        }else{
            $room_arr=array(1,999);
        }
        $search_s =($search_q==null ||$search_q=='-1')?'%':$search_q;                       
                \Debugbar::error(Carbon::now());
               // exit;
        
        $page_row = 20;

        $Hotel = Hotel::where('hotel_list.state','LIKE',$state_s)->where('hotel_list.version','LIKE',$ver_s)->where('hotel_list.illegal_homestay','LIKE',$illegal_s)->where('hotel_list.area_level2','LIKE',$area2_s)->where('hotel_list.area_level3','LIKE',$area3_s)->where('hotel_list.control','LIKE',$ctrl_s)->where('hotel_list.control','LIKE',$ctrl_s)->where('hotel_list.cooperation','LIKE',$c_type_s)->where('hotel_list.holiday','LIKE',$holiday_s)->whereBetween('hotel_list.type_room',$room_arr)->where('hotel_list.name','LIKE','%'.$search_s.'%')->leftJoin('manager_list','hotel_list.created_manager_id', '=', 'manager_list.id')->select('hotel_list.nokey','hotel_list.name','hotel_list.state','hotel_list.invoice_type','hotel_list.version','hotel_list.fees_c','hotel_list.fees_c_bonus','hotel_list.type_room','hotel_list.cooperation','hotel_list.control', 'hotel_list.deposit')->OrderBy('hotel_list.nokey','desc')->paginate($page_row)->appends($queryString);
        
        
        $Areas_level2 =Areas::where('area_level','2')->where('area_code', '=', session()->get('manager_country'))->get(); 
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,   
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Hotels' => $Hotel,
            'Areas_level2' => $Areas_level2,
            'QueryArray' => $queryString,
        ];
        return view('auth.hotel_list', $binding);
    }
// 
    public function add($country){
        $auth_key ='2'; 
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return redirect('/'. $country .'/auth/manager/hotel_list')->withErrors($errors)->withInput();
            //exit;
        }

        $Areas_level2 =Areas::where('area_level','2')->where('area_code', '=', session()->get('manager_country'))->get(); 

        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,    
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Areas_level2' => $Areas_level2,
        ];
        return view('auth.hotel_add', $binding);
    }

    public function addPost($country){
        
        $request =request()->all();
        
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail();
        $hotel =new Hotel;
        $hotel->contract_no=$request['contract_no'];                    
        $hotel->name=$request['name'];                                  
        $hotel->version=$request['ver'];                                
        $hotel->cooperation=$request['cooperation'];                    
        $hotel->state=$request['state'];                                
        $hotel->url=$request['url'];                                    
        $hotel->deposit=$request['deposit'];                            
        $hotel->control=$request['control'];                            
        $hotel->area_level1=$request['area_level1'];                    
        $hotel->area_level2=$request['area_level2'];                    
        $hotel->area_level3=$request['area_level3'];                    
        $hotel->zip_code=$request['zip_code'];                          
        $hotel->address=$request['address'];                            
        $hotel->notice="訂房須知\r\n\r\n1.本交易價格均已內含營業稅及服務費。\r\n\r\n2.更改入住日期：\r\n　(1)訂房後如欲更改訂房日期，請聯絡飯店訂房中心協助處理，惟限於入住日前7天（不含入住當日）更改，不另收手續費。\r\n如未於期限完成更改資料，則維持原訂房資料，旅客不得異議。\r\n\r\n(2)同一筆訂單限更改一次，且更改後的訂單恕不接受退房，否則視同取消訂房，不保留訂房費用。\r\n(3)如更改後訂單金額大於原訂單金額，旅客需現場另行支付差額；如更改後金額小於原訂單金額，恕不退還差額。\r\n\r\n取消訂房說明： \r\n於預定住宿日14日前解約，訂金扣除100元手續費，其餘退還；\r\n於預定住宿日10~13日前解約，退還70%已付定金；\r\n於預定住宿日7~9日前解約，退還50%已付定金；\r\n於預定住宿日4~6日前解約，退還40%已付訂金；\r\n於預定住宿日2~3日前解約，退還30%已付訂金；\r\n於預定住宿日1日前解約，退還20%已付訂金；\r\n於預定住宿日當日到達或怠於通知者，不退還旅客已付全部訂金。\r\n※春節與連續假期為保障其他旅客權益，訂房完成後無法取消退款。\r\n※若因天然災害等不可抗拒因素（如地震、颱風等，以飯店所在地縣市政府公告為準）無法如期前往住宿，請於原訂住宿日起3日（含當日）\r\n內與飯店之訂房中心連絡改期（限展延三個月內消費）。如欲辦理退房依照〔取消訂房〕之規定辦理。";
        $hotel->fees_c=(!empty($request['fees_c']))?$request['fees_c']:0;                            
        $hotel->fees_c_bonus=(!empty($request['fees_c_bonus']))?$request['fees_c_bonus']:0;
        $hotel->fees_ab=(!empty($request['fees_ab']))?$request['fees_ab']:0;                           
        $hotel->fees_ab_bonus=(!empty($request['fees_ab_bonus']))?$request['fees_ab_bonus']:0;
        $hotel->fees_d=(!empty($request['fees_d']))?$request['fees_d']:0;                          
        $hotel->fees_d_bonus=(!empty($request['fees_d_bonus']))?$request['fees_d_bonus']:0;
        $hotel->fees_sale_bonus=(!empty($request['fees_sale_bonus']))?$request['fees_sale_bonus']:0;
        $hotel->fees_sale_state=(!empty($request['fees_sale_state']))?$request['fees_sale_state']:0;
        $hotel->fees_roll_bonus=(!empty($request['fees_roll_bonus']))?$request['fees_roll_bonus']:0;
        $hotel->fees_roll_state=(!empty($request['fees_roll_state']))?$request['fees_roll_state']:0;   
        $hotel->license_hotel=(!empty($request['license_hotel']))?$request['license_hotel']:0;
        $hotel->license_homestay=(!empty($request['license_homestay']))?$request['license_homestay']:0;
        $hotel->license_hospitable=(!empty($request['license_hospitable']))?$request['license_hospitable']:0;
        $hotel->illegal_homestay=(!empty($request['illegal_homestay']))?$request['illegal_homestay']:0;         
        $hotel->tel1=$request['tel1'];                                  
        $hotel->tel2=$request['tel2'];                                  
        $hotel->fax1=$request['fax1'];                                  
        $hotel->fax2=$request['fax2'];                                  
        $hotel->email1=$request['email1'];                              
        $hotel->email2=$request['email2'];                              
        $hotel->track=$request['track'];                                
        $hotel->track_comm=$request['track_comm'];                      
        $hotel->app_line=$request['app_line'];                          
        $hotel->app_wechat=$request['app_wechat'];                      
        $hotel->checkout=$request['checkout'];                          
        $hotel->booking_day=$request['booking_day'];                    
        $hotel->invoice_type=$request['invoice_type'];                  
        $hotel->coordinate=$request['coordinate'];                      
        $hotel->type_scale=$request['type_scale'];                      
        $hotel->type_level=$request['type_level'];                      
        $hotel->type_room=$request['type_room'];                        
        $hotel->local_police=$request['local_police'];                  
        $hotel->local_police_comm=$request['local_police_comm'];        
        $hotel->invoice=$request['invoice'];                            
        $hotel->seo_title=$request['seo_title'];                        
        $hotel->seo_keyword=$request['seo_keyword'];                    
        $hotel->seo_descript=$request['seo_descript'];                  
        $hotel->reg_name=$request['reg_name'];                          
        $hotel->reg_no=$request['reg_no'];                              
        $hotel->credit_card=$request['credit_card'];                    
        $hotel->display_tel=$request['display_tel'];                    
        $hotel->bank_name=$request['bank_name'];                        
        $hotel->bank_code=$request['bank_code'];                        
        $hotel->bank_account=$request['bank_account'];                  
        $hotel->bank_account_name=$request['bank_account_name'];        
        $hotel->point=$request['point'];                                
        $hotel->contact_name=$request['contact_name'];                  
        $hotel->contact_job=$request['contact_job'];                    
        $hotel->contact_tel=$request['contact_tel'];                    
        $hotel->contact_mobile=$request['contact_mobile'];              
        $hotel->contact_line=$request['contact_line'];                  
        $hotel->contact_wechat=$request['contact_wechat'];              
        $hotel->contact_email=$request['contact_email'];                
        $hotel->contact_text=$request['contact_text'];                  
        $hotel->manage_url=$request['manage_url'];                      
        $hotel->manage_surl=$request['manage_surl'];                    
        $hotel->c_url=$request['c_url'];                                
        $hotel->c_surl=$request['c_surl'];                              
        $hotel->d_url=$request['d_url'];                                
        $hotel->d_surl=$request['d_surl'];                              
        $hotel->d_display_tel=$request['d_display_tel'];  
        $hotel->d_enable=(!empty($request['d_enable']))?$request['d_enable']:0;
        $hotel->ab_url=$request['ab_url'];                              
        $hotel->login_name=$request['login_name'];                      
        $hotel->login_com=$request['login_com'];                        
        $hotel->login_job=$request['login_job'];                        
        $hotel->login_addr_level1=$request['login_area_level1'];        
        $hotel->login_addr_level2=$request['login_area_level2'];        
        $hotel->login_addr_level3=$request['login_area_level3'];        
        $hotel->login_addr=$request['login_addr'];                      
        $hotel->login_tel=$request['login_tel'];                        
        $hotel->login_mobile=$request['login_mobile'];                  
        $hotel->login_email=$request['login_email'];                    
        $hotel->login_id=$request['login_id'];                          
        if(!empty($request['login_passwd'])){
            $request['login_passwd']=Hash::make($request['login_passwd']);
        }
        $hotel->login_passwd=$request['login_passwd'];                  
        $hotel->login_is_group=$request['login_is_group'];              
        $hotel->login_group_name=$request['login_group_name'];          
        $hotel->login_group_url=$request['login_group_url'];            
        $hotel->login_group_count=$request['login_group_count'];        
        $hotel->holiday=$request['holiday'];                            
        $hotel->expire=$request['expire'];                              
        $hotel->sort=$request['sort'];                                  
        $hotel->created_manager_name=session()->get('manager_name');    
        $hotel->created_manager_id=session()->get('manager_id');        
        $hotel->save();
        
        if ($request['login_id'] !='') {
            
            $h_auth =HotelAuthority::get(['nokey'])->toArray();
            $auth_string='';
            
            foreach($h_auth as $auth){
                $auth_string .=$auth['nokey'].',';
            }
            $auth_string =substr($auth_string,0,-1);                     
            // echo $auth_string;
            //
            $hotel_menager =new HotelManagers;
            $hotel_menager->id=$request['login_id'];
            $hotel_menager->passwd=Hash::make($request['login_passwd']);
            $hotel_menager->hotel_list_id=$hotel->nokey;
            $hotel_menager->name=$request['login_name'];
            $hotel_menager->department=$request['login_com'];
            $hotel_menager->auth=$auth_string;
            $hotel_menager->ip=Request::ip();
            $hotel_menager->created_id=session()->get('manager_id');
            $hotel_menager->created_name=session()->get('manager_name');
            $hotel_menager->save();
        }
        return redirect()->to('/'. $country .'/auth/manager/hotel_add')->with('controll_back_msg', 'ok');
    }
// 
    public function edit($country,$hotelKey){
        $auth_key ='3'; 
        
        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,    
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return redirect('/'. $country .'/auth/manager/hotel_list')->withErrors($errors)->withInput();
            //exit;
        }
        // 
        $Hotel =Hotel::where('nokey',$hotelKey)->firstOrFail();
        $Areas_level2 =Areas::where('area_level','2')->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $Addr_level3 =Areas::where('area_parent',$Hotel->area_level2)->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $Login_addr_level3 =Areas::where('area_parent',$Hotel->login_addr_level2)->where('area_code', '=', session()->get('manager_country'))->get(); //
        //
        $contact_column_count =7;
        $contact_arr =explode(',', $Hotel->contact_text);
        $contact_arr_rang =floor(count($contact_arr)/$contact_column_count)-1;  //
        $Contact_Array =array();
        for($i=0; $i<$contact_arr_rang; $i++){
            for($j=0; $j<$contact_column_count; $j++){
                if($i==0){
                    $Contact_Array[$i][$j] = $contact_arr[$j];
                }else{
                    $Contact_Array[$i][$j] = $contact_arr[($j+($i*$contact_column_count))];
                }
            }
        }
        // print_r($Contact_Array);
        // exit;
        //
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,  //  
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Areas_level2' => $Areas_level2,
            'Hotel' => $Hotel,
            'Addr_level3' => $Addr_level3,
            'Login_addr_level3' => $Login_addr_level3,
            'Contact' => $Contact_Array,
        ];
        return view('auth.hotel_edit', $binding);
    }
// 
    public function editPost($country,$hotelKey){
        $request =request()->all();

        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail();
        $hotel =Hotel::find($hotelKey);
        $hotel->contract_no=$request['contract_no'];                    
        $hotel->name=$request['name'];                                  
        $hotel->version=$request['ver'];                                
        $hotel->cooperation=$request['cooperation'];                    
        $hotel->state=$request['state'];                                
        $hotel->url=$request['url'];                                    
        $hotel->deposit=$request['deposit'];                            
        $hotel->control=$request['control'];                            
        $hotel->area_level1=$request['area_level1'];                    
        $hotel->area_level2=$request['area_level2'];                    
        $hotel->area_level3=$request['area_level3'];                    
        $hotel->zip_code=$request['zip_code'];                          
        $hotel->address=$request['address'];                            
        $hotel->fees_c=(!empty($request['fees_c']))?$request['fees_c']:0;                           
        $hotel->fees_c_bonus=(!empty($request['fees_c_bonus']))?$request['fees_c_bonus']:0;
        $hotel->fees_ab=(!empty($request['fees_ab']))?$request['fees_ab']:0;    
        $hotel->fees_ab_bonus=(!empty($request['fees_ab_bonus']))?$request['fees_ab_bonus']:0;
        $hotel->fees_d=(!empty($request['fees_d']))?$request['fees_d']:0;                  
        $hotel->fees_d_bonus=(!empty($request['fees_d_bonus']))?$request['fees_d_bonus']:0;
        $hotel->fees_sale_bonus=(!empty($request['fees_sale_bonus']))?$request['fees_sale_bonus']:0;
        $hotel->fees_sale_state=(!empty($request['fees_sale_state']))?$request['fees_sale_state']:0;
        $hotel->fees_roll_bonus=(!empty($request['fees_roll_bonus']))?$request['fees_roll_bonus']:0;
        $hotel->fees_roll_state=(!empty($request['fees_roll_state']))?$request['fees_roll_state']:0;   
        $hotel->license_hotel=(!empty($request['license_hotel']))?$request['license_hotel']:0;
        $hotel->license_homestay=(!empty($request['license_homestay']))?$request['license_homestay']:0;
        $hotel->license_hospitable=(!empty($request['license_hospitable']))?$request['license_hospitable']:0;
        $hotel->illegal_homestay=(!empty($request['illegal_homestay']))?$request['illegal_homestay']:0;         
        $hotel->tel1=$request['tel1'];                                  
        $hotel->tel2=$request['tel2'];                                  
        $hotel->fax1=$request['fax1'];                                  
        $hotel->fax2=$request['fax2'];                                  
        $hotel->email1=$request['email1'];                              
        $hotel->email2=$request['email2'];                              
        $hotel->track=$request['track'];                                
        $hotel->track_comm=$request['track_comm'];                      
        $hotel->app_line=$request['app_line'];                          
        $hotel->app_wechat=$request['app_wechat'];                      
        $hotel->checkout=$request['checkout'];                          
        $hotel->booking_day=$request['booking_day'];                    
        $hotel->invoice_type=$request['invoice_type'];                  
        $hotel->coordinate=$request['coordinate'];                      
        $hotel->type_scale=$request['type_scale'];                      
        $hotel->type_level=$request['type_level'];                      
        $hotel->type_room=$request['type_room'];                        
        $hotel->local_police=$request['local_police'];                  
        $hotel->local_police_comm=$request['local_police_comm'];        
        $hotel->invoice=$request['invoice'];                            
        $hotel->seo_title=$request['seo_title'];                        
        $hotel->seo_keyword=$request['seo_keyword'];                    
        $hotel->seo_descript=$request['seo_descript'];                  
        $hotel->reg_name=$request['reg_name'];                          
        $hotel->reg_no=$request['reg_no'];                              
        $hotel->credit_card=$request['credit_card'];                    
        $hotel->display_tel=$request['display_tel'];                    
        $hotel->bank_name=$request['bank_name'];                        
        $hotel->bank_code=$request['bank_code'];                        
        $hotel->bank_account=$request['bank_account'];                  
        $hotel->bank_account_name=$request['bank_account_name'];        
        $hotel->point=$request['point'];                                
        $hotel->contact_name=$request['contact_name'];                  
        $hotel->contact_job=$request['contact_job'];                    
        $hotel->contact_tel=$request['contact_tel'];                    
        $hotel->contact_mobile=$request['contact_mobile'];              
        $hotel->contact_line=$request['contact_line'];                  
        $hotel->contact_wechat=$request['contact_wechat'];              
        $hotel->contact_email=$request['contact_email'];                
        $hotel->contact_text=$request['contact_text'];                  
        $hotel->manage_url=$request['manage_url'];                      
        $hotel->manage_surl=$request['manage_surl'];                    
        $hotel->c_url=$request['c_url'];                                
        $hotel->c_surl=$request['c_surl'];                              
        $hotel->d_url=$request['d_url'];                                
        $hotel->d_surl=$request['d_surl'];                              
        $hotel->d_enable=(!empty($request['d_enable']))?$request['d_enable']:0;
        $hotel->d_display_tel=$request['d_display_tel'];                
        $hotel->ab_url=$request['ab_url'];                              
        $hotel->login_name=$request['login_name'];                      
        $hotel->login_com=$request['login_com'];                        
        $hotel->login_job=$request['login_job'];                        
        $hotel->login_addr_level1=$request['login_area_level1'];        
        $hotel->login_addr_level2=$request['login_area_level2'];        
        $hotel->login_addr_level3=$request['login_area_level3'];        
        $hotel->login_addr=$request['login_addr'];                      
        $hotel->login_tel=$request['login_tel'];                        
        $hotel->login_mobile=$request['login_mobile'];                  
        $hotel->login_email=$request['login_email'];                    
        
        $hotel->login_is_group=$request['login_is_group'];              
        $hotel->login_group_name=$request['login_group_name'];          
        $hotel->login_group_url=$request['login_group_url'];            
        $hotel->login_group_count=$request['login_group_count'];        
        $hotel->expire=$request['expire'];                              
        $hotel->holiday=$request['holiday'];                            
        $hotel->sort=$request['sort'];                                  
        $hotel->created_manager_name=session()->get('manager_name');    
        $hotel->created_manager_id=session()->get('manager_id');        
        $hotel->save();

        return redirect()->to('/'. $country .'/auth/manager/hotel_list');
    }

    public function browse($country,$hotelKey){
        $auth_key ='3'; 

        $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
        $auth_array =explode(',', session()->get('manager_auth'));
        if(!in_array($auth_key,$auth_array)){
            $errors =['權限不足返回'];
            $Manager =Managers::where('id',session()->get('manager_id'))->firstOrFail()->toArray();
            $binding =[
                'Title' => $this->menu_item_text,
                'Nav_ID' => $this->menu_item_code,  //
                'Manager' => $Manager,
                'Country' => $country,
            ];
            return redirect('/'. $country .'/auth/manager/hotel_list')->withErrors($errors)->withInput();
            //exit;
        }
        $Hotel_Comm =Hotel_Comm::where('hotel_id',$hotelKey)->OrderBy('updated_at','desc')->get();
        $Hotel =Hotel::where('nokey',$hotelKey)->firstOrFail();
        session()->put('manager_hotel_id',$Hotel->nokey);
        $Areas_level2 =Areas::where('area_level','2')->where('area_code', '=', session()->get('manager_country'))->get(); 
        $Addr_level3 =Areas::where('area_parent',$Hotel->area_level2)->where('area_code', '=', session()->get('manager_country'))->get(); 
        $Login_addr_level3 =Areas::where('area_parent',$Hotel->login_addr_level2)->where('area_code', '=', session()->get('manager_country'))->get(); 
        $contact_column_count =7;
        $contact_arr =explode(',', $Hotel->contact_text);
        $contact_arr_rang =floor(count($contact_arr)/$contact_column_count)-1;  
        $Contact_Array =array();
        for($i=0; $i<$contact_arr_rang; $i++){
            for($j=0; $j<$contact_column_count; $j++){
                if($i==0){
                    $Contact_Array[$i][$j] = $contact_arr[$j];
                }else{
                    $Contact_Array[$i][$j] = $contact_arr[($j+($i*$contact_column_count))];
                }
                
            }
        }
        // print_r($Hotel->contact_text);
        // exit;
        //
        $binding =[
            'Title' => $this->menu_item_text,
            'Nav_ID' => $this->menu_item_code,   
            'Manager' => $Manager,
            'Auths' => $auth_array,
            'Country' => $country,
            'Areas_level2' => $Areas_level2,
            'Hotel' => $Hotel,
            'Addr_level3' => $Addr_level3,
            'Login_addr_level3' => $Login_addr_level3,
            'Contact' => $Contact_Array,
            'Hotel_Comm' => $Hotel_Comm,
        ];
        return view('auth.hotel_browse', $binding);
    }

    public function disableAjax($country,$hotelKey){
        $hotel =Hotel::find($hotelKey);
        $hotel->state =2;
        $hotel->save();
        return 'OK';
    }

    public function addCommAjax($country,$hotelKey){
        $request =request()->all();
        $hotel_comm =new Hotel_Comm;
        $hotel_comm->hotel_id =$hotelKey;
        $hotel_comm->comm =$request['comm'];
        $hotel_comm->write_id =session()->get('manager_id');
        $hotel_comm->write_name =session()->get('manager_name');
        $hotel_comm->save();
        return 'OK';
    }

    public function toManager($country,$hotelKey){
        $room_id =RQ::input('r');
        echo $room_id;
        exit;
    }
}
