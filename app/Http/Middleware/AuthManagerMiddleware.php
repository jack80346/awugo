<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Hash;
use Closure;

class AuthManagerMiddleware
{
    /**
     * Handle an incoming request.
     * 判斷是否有管理者登入過的SESSION
     */
    public function handle($request, Closure $next)
    {
        //預防國籍資訊丟失session
        if(is_null(session()->get('manager_country'))){
            session()->put('manager_country','tw');
        }
        if(is_null(session()->get('manager_id'))){
            return redirect()->to(session()->get('manager_country').'/auth/login');
        }
        return $next($request);
    }
}
