<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class ReservationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //(Auth::user() && (auth()->user()->role!=='resv' || auth()->user()->role!=='admin') does not work
        if(Auth::user() && auth()->user()->role!=='resv')
        {
            if(Auth::user() && auth()->user()->role!=='admin')
            {
                abort(403,'Unauthorised access');
            }                  
        }
        return $next($request);
        
    }
}
