<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Utilizador;

class Banido {
    public function handle(Request $request, Closure $next) {

        if(Auth::guest()) {
            return $next($request);
        }

        if(!Auth::user()->permissao == 'b') {
            return(redirect('/'));
        }

        return $next($request);
    }
}