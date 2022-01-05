<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class NaoBanido {

    public function handle (Request $request, Closure $next) {

        if(Auth::guest()) {
            return $next($request);
        }

        if(!Auth::user() -> permissao == 'b') {
            return (redirect('ban'));
        }

        return $next($request);
    }
}