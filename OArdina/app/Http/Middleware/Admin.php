<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Utilizador;

class Admin {
    public function handle (Request $request, Closure $next) {
        
        if(!Auth::user()->permissao == 'a') {
            return(redirect('/'));
        }

        return $next($request);
    }
}