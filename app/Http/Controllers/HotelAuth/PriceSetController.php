<?php

namespace App\Http\Controllers\HotelAuth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Awugo\Auth\HotelManagers;
use App\Awugo\Auth\Hotel;
use App\Awugo\HotelAuth\HotelRoomSet;
use App\Awugo\HotelAuth\HotelPriceNormal;
use App\Awugo\HotelAuth\HotelPriceSpecial;

use Image;
use View;
use DB;
use Validator;
use Debugbar;
use Carbon;
use File;
use Request as RQ;

class PriceSetController extends Controller
{
    // 
    public function price($country, $hotel_id){
        
        // 
        $Hotel =Hotel::find(substr($hotel_id, 1));

        $binding =[
            'Title' => '全部房價',
            'Nav_ID' => 10,  //  
            'Hotel_ID' => $hotel_id,
            'Hotel' =>$Hotel,
            'Country' => $country,
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
            $RoomList =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->where('nokey', $room_id)->get();
            // echo 0;
        }else{
            $RoomList =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->get();
            // echo 1;
        }
        if(count($RoomList)<=0){
            echo "<script>alert('請先設定客房與儲存客房設定');window.location.href='room_set';</script>";
        }
        //
        $RoomSelect =HotelRoomSet::where('hotel_id', substr($hotel_id, 1))->get();

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

        $binding =[
            'Title' => '全部房價',
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
            'PriceSpecialMaxCount' => $PriceSpecial_max_count,
        ];
        return view('hotel_auth.price_normal',$binding);
    }

    // 
    public function price_normal_post($country, $hotel_id){
        //
        $request =request()->all();
        $room_id =RQ::input('r');

        //dd($request);
        //
        $totalSet =$request['totalPriceSet']*$request['totalSalePeople'];
        $j=0;
        $year_str=array();
        // dd(count($request['sale_people']));
        // exit;
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
}
