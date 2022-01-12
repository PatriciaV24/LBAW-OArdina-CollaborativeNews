<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class NotBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guest())
        return $next($request);
        
        Auth::user()->checkBan();
        if(Auth::user()->is_banned){
            return(redirect('ban'));
        }
         
        return $next($request); 
    }
}