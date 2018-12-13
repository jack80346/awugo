<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Hotel;
use App\Awugo\Auth\Suit_Name;
use App\Awugo\HotelAuth\HotelRoomSet;
use App\Awugo\HotelAuth\HotelPriceNormal;
use App\Awugo\HotelAuth\HotelPriceSpecial;
use App\Awugo\HotelAuth\HotelSuitPriceNormal;
use App\Awugo\HotelAuth\HotelSuitPriceSpecial;

use Image;
use View;
use DB;
use Validator;
use Debugbar;
use Carbon\Carbon;
use File;
use Request as RQ;

class PriceSetController extends Controller
{
    // 
    public function price($country, $hotel_id){
        
        //抓取期別(201812)
        $period =RQ::input('p');

        //Carbon
        $tb = Carbon::today();
        $ft = Carbon::create($tb->year, $tb->month, 1, 0);
        $ft_dayofweek = $ft->dayOfWeek;
        
        $ft_start = $ft->copy();
        $ft_next = $ft->addMonths(1);

        //dd($ft_next->format('Y-m-01'));

        if(empty($period)){
            $period = $tb->format('Ym');
        }

        $cur_year = (int)substr($period,0,4);
        $cur_month = (int)substr($period,4,2);

        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));

        

        //各月份-日期
        $month_day = [0,31,28,31,30,31,30,31,31,30,31,30,31];
        //星期
        $week_day = ['日','一','二','三','四','五','六'];
        //本月日期(考慮閏年)
        $all_day = $month_day[$cur_month];
        $all_day = ($cur_month==2 && $cur_year%4==0)? $all_day+1: $all_day;

        //開始組裝陣列
        $all_date = [];
        $all_price = [];
        for($i=1; $i<=$all_day; $i++){
           $obj = [];
           $obj['date']=$i; 
           $obj['weekday']=($ft_dayofweek+$i-1)%7; 
           $all_date[] = $obj;
        }
        //dd($all_date);

        //各房間設定
        $RoomList =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->get();

        foreach ($RoomList as $room) {

            $room_name = $room->name;
            $room_sale = empty($room->sale_people)? [] :array_filter(explode(',',$room->sale_people));
            //依人數排列 ex:[5,4,3]
            arsort($room_sale);
            
            //先抓符合時間區間的常態性房價(一~五)
            $nomal_price = HotelPriceNormal::where('hotel_id', substr($hotel_id, 1))->where('room_id', $room->nokey)->where('start','>=', $ft_start->format('Y-m-01'))->where('end','<', $ft_next->format('Y-m-01'))->get();

            
            //再抓特殊假期之房價
            $special_price = HotelPriceSpecial::where('hotel_id', substr($hotel_id, 1))->where('room_id', $room->nokey)->where('period_year',$cur_year)->where('period_start','>=', $ft_start->format('m01'))->where('period_end','<', $ft_next->format('m01'))->get();

            $day_price = [];
            foreach ($room_sale as $sale) {
                $sale_list = [];
                for($i=1; $i<=$all_day; $i++){
                   $day_price[] = 0; 
                }

                $sale_temp = [
                    'people'=>$sale,
                    'day_price'=>$day_price
                ];
                
                $sale_list[] = $sale_temp;
            }

            $room_data = [
                'name'=>$room->name,
                'sale'=>$sale_list
                //'nomal'=>$nomal_price->toArray(),
                //'special'=>$special_price->toArray(),
            ];

            $all_price[] = $room_data;
        }
        //dd($all_price);

        $binding =[
            'Title' => '全部房價',
            'Nav_ID' => 10,  //  
            'Hotel_ID' => $hotel_id,
            'Hotel' =>$Hotel,
            'Country' => $country,
            'MonthDay' => $month_day,
            'WeekDay' => $week_day,
            'Period' => $period,
            'AllDate' => $all_date,
            'AllPrice' => $all_price,
        ];
        return view('hotel_auth.price',$binding);
    }

    // 
    public function price_normal($country, $hotel_id){
        $room_id =RQ::input('r');
        $browseTag =(RQ::input('b')!=1)?0:1;
        $addRowTag =RQ::input('c','');
        // 
        $RoomList =null;
        if($room_id !=null){
            $RoomList =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->where('nokey', $room_id)->get();
            // echo 0;
        }else{
            $RoomList =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->get();
            // echo 1;
        }
        if(count($RoomList)<=0){
            echo "<script>alert('請先設定客房與儲存客房設定');window.location.href='room_set';</script>";
        }
        //
        $RoomSelect =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->get();

        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));
     // exit;   
        // 
        $RoomSale =substr($RoomList[0]->sale_people, 0, -1);

        $RoomSaleArray =explode(',', $RoomSale);

        // dd($RoomSelect);
        // exit;
        // 
        $room_key=$RoomList[0]->nokey;
        if($room_id !=null){
            $room_key=$room_id;
        }
        $PriceNormal =HotelPriceNormal::where('hotel_id',substr($hotel_id, 1))->where('room_id',$room_key)->OrderBy('merge','asc')->OrderBy('people','desc')->get();
        // 
        $MergeLastNo =0;
        $MergeNo =HotelPriceNormal::where('hotel_id',substr($hotel_id, 1))->where('room_id',$room_key)->OrderBy('merge','desc')->select('merge')->first();
        if(isset($MergeNo)){
            $MergeLastNo =$MergeNo->merge;
        }

        $current_year = (int)date("Y")-1911;
        
        $PeriodYear = [$current_year-1,$current_year,$current_year+1];
        if($RoomList[0]->show_last_year==0){
            array_shift($PeriodYear);
        }
        $PriceSpecial = HotelPriceSpecial::where('hotel_id',substr($hotel_id, 1))->where('room_id',$room_key)->whereIn( "period_year", $PeriodYear)->OrderBy('period_year','asc')->OrderBy('people','desc')->OrderBy('period_start','asc')->get()->groupBy("period_year");

        $PriceSpecial_max_count = 0;
        foreach ($PriceSpecial as $year => $special) {
            if(($special->count())>$PriceSpecial_max_count){
                $PriceSpecial_max_count = $special->count();
            }
        }
        //dd($PriceSpecial->toArray());
        $weekday_checkin_hour = $weekday_checkin_minute = $holiday_checkin_hour = $holiday_checkin_minute = 0;
        if($RoomList[0]->weekday_checkin){
            $weekday_checkin_arr = explode(":", $RoomList[0]->weekday_checkin);
            $weekday_checkin_hour = (int)$weekday_checkin_arr[0];
            $weekday_checkin_minute = (int)$weekday_checkin_arr[1];
        }
        if($RoomList[0]->holiday_checkin){
            $holiday_checkin_arr = explode(":", $RoomList[0]->holiday_checkin);
            $holiday_checkin_hour = (int)$holiday_checkin_arr[0];
            $holiday_checkin_minute = (int)$holiday_checkin_arr[1];
        }

        $weekday_checkout_hour = $weekday_checkout_minute = $holiday_checkout_hour = $holiday_checkout_minute = 0;
        if($RoomList[0]->weekday_checkout){
            $weekday_checkout_arr = explode(":", $RoomList[0]->weekday_checkout);
            $weekday_checkout_hour = (int)$weekday_checkout_arr[0];
            $weekday_checkout_minute = (int)$weekday_checkout_arr[1];
        }
        if($RoomList[0]->holiday_checkout){
            $holiday_checkout_arr = explode(":", $RoomList[0]->holiday_checkout);
            $holiday_checkout_hour = (int)$holiday_checkout_arr[0];
            $holiday_checkout_minute = (int)$holiday_checkout_arr[1];
        }

        $otherSetting = [];
        $otherSetting['continuous_sale'] = ($RoomList[0]->continuous_sale>0)? $RoomList[0]->continuous_sale: 0;
        
        $otherSetting['weekday_checkin_hour'] = $weekday_checkin_hour;
        $otherSetting['weekday_checkin_minute'] = $weekday_checkin_minute;
        $otherSetting['holiday_checkin_hour'] = $holiday_checkin_hour;
        $otherSetting['holiday_checkin_minute'] = $holiday_checkin_minute;
        $otherSetting['checkin_same'] = (bool)($weekday_checkin_hour==$holiday_checkin_hour && $weekday_checkin_minute==$holiday_checkin_minute);
        
        $otherSetting['weekday_checkout_hour'] = $weekday_checkout_hour;
        $otherSetting['weekday_checkout_minute'] = $weekday_checkout_minute;
        $otherSetting['holiday_checkout_hour'] = $holiday_checkout_hour;
        $otherSetting['holiday_checkout_minute'] = $holiday_checkout_minute;
        $otherSetting['checkout_same'] = (bool)($weekday_checkout_hour==$holiday_checkout_hour && $weekday_checkout_minute==$holiday_checkout_minute);

        $binding =[
            'Title' => '一般房價',
            'Nav_ID' => 10,   
            'Hotel_ID' => $hotel_id,
            'Hotel' =>$Hotel,
            'Room_Key' =>$room_key,
            'RoomList' =>$RoomList,
            'RoomSelect' =>$RoomSelect,
            'RoomSaleArray' =>$RoomSaleArray,
            'PriceNormal' =>$PriceNormal,
            'PriceSpecial' =>$PriceSpecial,
            'PeriodYear' =>$PeriodYear,
            'MergeLastNo' =>$MergeLastNo,
            'BrowseTag' =>$browseTag,
            'AddRowTag' =>$addRowTag,
            'RoomID' =>$room_id,
            'Country' => $country,
            'OtherSetting' => $otherSetting,
            'PriceSpecialMaxCount' => $PriceSpecial_max_count,
        ];
        return view('hotel_auth.price_normal',$binding);
    }

    // 
    public function price_normal_post($country, $hotel_id){
        //
        $request =request()->all();
        $room_id =RQ::input('r');

        if($room_id ==null){
            $room_id =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->first()->nokey;
        }

        //dd($request);exit;

        //normal
        $totalSet =$request['totalPriceSet']*$request['totalSalePeople'];
        $j=0;
        $year_str=array();

        for ($k=0;$k<count($request['sale_people']);$k++) {
            if(($k)==$request['totalSalePeople']){
                $j++;
            }
            array_push($year_str, $request['sale_people'][$k].''.$j);
        }
        $PriceNormal =HotelPriceNormal::where('hotel_id',substr($hotel_id, 1))->where('room_id',$request['room_list']);
        $PriceNormal->delete();

        for ($i=0;$i<count($request['sale_people']);$i++) {
            $PriceNormal =new HotelPriceNormal;
            $PriceNormal->hotel_id =substr($hotel_id, 1);
            $PriceNormal->room_id =$request['room_list'];
            $PriceNormal->merge =floor($i/$request['totalSalePeople']);
            $PriceNormal->people =$request['sale_people'][$i];
            $PriceNormal->weekday =$request['weekday'][$i];
            $PriceNormal->friday =$request['friday'][$i];
            $PriceNormal->saturday =$request['saturday'][$i];
            $PriceNormal->sunday =$request['sunday'][$i];
            $PriceNormal->is_year =1;
            $PriceNormal->start =date("Y").'-'.str_pad($request['price_time_month_start'][$i],2,'0',STR_PAD_LEFT)."-". str_pad($request['price_time_day_start'][$i],2,'0',STR_PAD_LEFT);
            $PriceNormal->end =date("Y").'-'.str_pad($request['price_time_month_end'][$i],2,'0',STR_PAD_LEFT)."-". str_pad($request['price_time_day_end'][$i],2,'0',STR_PAD_LEFT);
            $PriceNormal->creator_id =session()->get('manager_id');
            $PriceNormal->creator_name =session()->get('manager_name');
            $PriceNormal->save();
        }

        //special
        if(!empty($request['Special'])){
            
            $Special = $request['Special'];
            
            $priceArr = $Special["price"];
            $yearArr = $Special["year"];
            $peopleArr = $Special["sale_people"];
            $startArr = $Special["period_start"];
            $endArr = $Special["period_end"];

            $PriceSpecial =HotelPriceSpecial::where('hotel_id',substr($hotel_id, 1))->where('room_id',$request['room_list']);
            $PriceSpecial->delete();
            for ($i=0;$i<count($priceArr);$i++) {
                $PriceSpecial =new HotelPriceSpecial;
                $PriceSpecial->hotel_id =substr($hotel_id, 1);
                $PriceSpecial->room_id =$request['room_list'];
                $PriceSpecial->period_year =$yearArr[$i];
                $PriceSpecial->period_start =$startArr[$i];
                $PriceSpecial->period_end =$endArr[$i];
                $PriceSpecial->people =$peopleArr[$i];
                $PriceSpecial->price =$priceArr[$i];
                $PriceSpecial->creator_id =session()->get('manager_id');
                $PriceSpecial->creator_name =session()->get('manager_name');
                $PriceSpecial->save();
            }
        }

        

        //room set
        $RoomSet = HotelRoomSet::find($room_id);

        $RoomSet->continuous_sale = 0;
        if($request['continuous_sale_w']==1 && $request['continuous_sale']>0 && $request['continuous_sale']<=100){
           $RoomSet->continuous_sale = $request['continuous_sale'];
            $RoomSet->save();
        }

        return redirect()->to("/tw/auth/h".substr($hotel_id, 1)."/price_normal?r=".$room_id."&b=1");
    }

    public function other_setting_post($country, $hotel_id){

        $request =request()->all();
        $room_id =RQ::input('r');

        if($room_id ==null){
            $room_id =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->first()->nokey;
        }

        //dd($request);exit;

        //room set
        $RoomSet = HotelRoomSet::find($room_id);

        $RoomSet->continuous_sale = 0;
        if($request['continuous_sale_w']==1 && $request['continuous_sale']>0 && $request['continuous_sale']<=100){
           $RoomSet->continuous_sale = $request['continuous_sale'];
        }
        if($request['weekday-checkin-hour']>=0 && $request['weekday-checkin-hour']<24 && $request['weekday-checkin-minute']>=0 && $request['weekday-checkin-minute']<60){
            $RoomSet->weekday_checkin = $request['weekday-checkin-hour'].":".$request['weekday-checkin-minute'];
            
            if(isset($request['checkin-same']) && $request['checkin-same']=="on"){
                $RoomSet->holiday_checkin = $request['weekday-checkin-hour'].":".$request['weekday-checkin-minute'];
            }else{
                if($request['holiday-checkin-hour']>=0 && $request['holiday-checkin-hour']<24 && $request['holiday-checkin-minute']>=0 && $request['holiday-checkin-minute']<60){
                    $RoomSet->holiday_checkin = $request['holiday-checkin-hour'].":".$request['holiday-checkin-minute'];
                }
            }
        }
        if($request['weekday-checkout-hour']>=0 && $request['weekday-checkout-hour']<24 && $request['weekday-checkout-minute']>=0 && $request['weekday-checkin-minute']<60){
            $RoomSet->weekday_checkout = $request['weekday-checkout-hour'].":".$request['weekday-checkout-minute'];
            
            if(isset($request['checkout-same']) && $request['checkout-same']=="on"){
                $RoomSet->holiday_checkout = $request['weekday-checkout-hour'].":".$request['weekday-checkout-minute'];
            }else{
                if($request['holiday-checkout-hour']>=0 && $request['holiday-checkout-hour']<24 && $request['holiday-checkout-minute']>=0 && $request['holiday-checkout-minute']<60){
                    $RoomSet->holiday_checkout = $request['holiday-checkout-hour'].":".$request['holiday-checkout-minute'];
                }
            }
        }

        $RoomSet->save();
        return redirect()->to("/tw/auth/h".substr($hotel_id, 1)."/price_normal?r=".$room_id."&b=1");
    }

    public function price_normal_del($country, $hotel_id){
        $request =request()->all();

        $room_id =$request['room_id'];
        $merge =$request['merge'];

        $PriceNormal =HotelPriceNormal::where('merge',($merge-1))->where('room_id',$room_id);
        $PriceNormal->delete();

        return 'ok';
    }

    public function price_special_del($country, $hotel_id){
        $request =request()->all();

        $PriceSpecial = HotelPriceSpecial::whereIn('nokey',$request["keys"]);
        $PriceSpecial->delete();

        return 'ok';
    }

    public function dont_show_last_year($country, $hotel_id){
        $request =request()->all();

        $RoomSet = HotelRoomSet::where('hotel_id',substr($hotel_id, 1))->where('nokey',$request["room_id"]);
        $RoomSet->update(['show_last_year'=>0]);

        return 'ok';
    }

    public function price_suit($country, $hotel_id){
        $suit_id =RQ::input('s');
        $browseTag =(RQ::input('b')!=1)?0:1;
        $addMode =(RQ::input('a')!=1)?0:1;
        $addRowTag =RQ::input('c','');

        $SuitSelect =Suit_Name::where('hotel_id', substr($hotel_id, 1))->get();
        $RoomSelect =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('room_type', '>=', 0)->get();
        if(count($RoomSelect)<=0){
            echo "<script>alert('請先設定客房與儲存客房設定');window.location.href='room_set';</script>";
        }

        $suitName = null;
        $suitNormal = null;
        $suitSpecial = null;

        if($suit_id !=null){
            $suitName = Suit_Name::find($suit_id)->get();
        }else{
            $suitName = Suit_Name::first();
        }

        if(!$suitName && $addMode==0){
            $addMode = 1;
        }else{
           $suitNormal = HotelSuitPriceNormal::where($suitName->nokey)->get(); 
           $suitSpecial = HotelSuitPriceSpecial::where($suitName->nokey)->get(); 
        }

        $room_id=0;

        $Hotel =Hotel::find(substr($hotel_id, 1));
        $RoomSale =substr($RoomSelect[0]->sale_people, 0, -1);
        $RoomSaleArray =explode(',', $RoomSale);

        $binding = [
            'Title' => '套裝方案',
            'Nav_ID' => 10,   
            'Hotel_ID' => $hotel_id,
            'Hotel' =>$Hotel,
            'RoomID' =>$room_id,
            'SuitID' =>$suit_id,
            'Country' => $country,
            'SuitName' => $suitName,
            'RoomSelect' => $RoomSelect,
            'AddMode' => $addMode,
            'suitNormal' => $suitNormal,
            'suitSpecial' => $suitSpecial,
        ];

        $tpl = ($addMode)?'hotel_auth.price_suit_add':'hotel_auth.price_suit';

        return view($tpl,$binding);
    }

    public function price_suit_post($country, $hotel_id){
        $request =request()->all();
        $room_id =RQ::input('r');

    }
}
