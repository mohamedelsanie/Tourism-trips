<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(getSetting('site_status') == 'closed'){
            if(Auth::guard('admin')->user()){
                return $next($request);
            }else{
                if(\Route::currentRouteName() != 'closed'){
                    return redirect()->route('closed');
                }
            }
        }

        return $next($request);
    }
}
