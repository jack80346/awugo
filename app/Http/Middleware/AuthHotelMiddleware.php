<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Hash;
use Closure;

class AuthHotelMiddleware
{
    /**
     * Handle an incoming request.
     * 判斷是否有管理者登入過的SESSION
     */
    public function handle($request, Closure $next)
    {
        //取得route參數
        $hotel_id = $request->route()->parameters()['hotel_id'];
        //預防國籍資訊丟失session
        if(is_null(session()->get('manager_country'))){
            session()->put('manager_country','tw');
            session()->put('hotel_country','tw');
        }
        //驗證登入資訊，沒登入資訊遺失則導向到登入口(原404)
        if(is_null(session()->get('hotel_manager_id')) || is_null(session()->get('hotel_id')) || is_null($hotel_id)){
            return redirect()->to(session()->get('manager_country').'/auth/'.$hotel_id);
        }
        // 比對session hotel id與存取hotel id是否相同
        if($hotel_id !=session()->get('hotel_id')){
            session()->flush();

            session()->put('hotel_country', 'tw');
            session()->put('manager_country', 'tw');
            return redirect()->to('/'. $country .'/auth/'.$hotel_id);
        }
        // echo $hotel_id;
        //     exit;
        // 驗證非總管理過來、總管理身分、飯店管理員身分都導向404
        // if(is_null(session()->get('manager_id')) && is_null(session()->get('manager_hotel_id')) && is_null(session()->get('hotel_id')) && is_null($hotel_id)){
        //     return redirect()->to(session()->get('manager_country').'/auth/');
        // }

        //驗證route參數正確，不正確導向404偽裝
        if(!is_numeric(substr($hotel_id, 1)) || substr($hotel_id, 0, 1)!='h'){
            return redirect()->to(session()->get('manager_country').'/auth/'.$hotel_id);
        }
        
        return $next($request);
    }
}
