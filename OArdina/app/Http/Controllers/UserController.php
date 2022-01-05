<?php

namespace App\Http\Controllers;

use Illuminate\Http\Requet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use App\Models\Utilizador;
use App\Models\Noticia;
use Carbon\Carbon;

class UserController extends Controller {
    
    public function show($utilizador) {
        
        $this->authorize('viewAny', Utilizador::class);

        $user = Utilizador::getUser($utilizador);

        if($user == null || $user -> permissao == 'b') {
            return view('errors.404');
        }

        $noticias = $user->noticias();

        $noticiasrec = $noticias->sortByDesc('data');

        return view('pages.user', [
            'user' => $user,
            'noticiasrec' => $noticiasrec
        ]);
    }

    public function showEditPage($utilizador) {
        
        $user = Utilizador::getUser($utilizador);
        $this -> authorize('update', $user);
        return view('pages.edit_user');

    }

    public function updatePassword(Request $request) {
    
        $validator = Validator::make($request->all(), [
            'passantiga' => 'required|string',
            'passnova' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/regex:/[0-9]',
            'confirmPassNova' => 'required | same: passnova'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        if(!Hash::check($request->passantiga, Auth::user()->password)) {
            return back()->withErrors([
                'passantiga' => ['A password não se encontra nos nossos registos']
            ]);
        }

        Auth::user()->password =bcrypt($request->passnova);
        Auth::user()->save();

        return view('pages.edit_user');
    }

    public function updateUtilizador(Request $request) {
        $this->authorize('update', Auth::user());

        Validator::make($request->all(), [
            'nome' => 'required|string|max:16|unique:utilizador, username,'.(string)Auth::id(),
            'email' => 'required|string|email|max:255|unique:utilizador, email'.(string)Auth::id(),
            'contacto' => 'required|integer|unique:utilizador'
        ])->validate();

        Auth::user() -> nome = $request -> nome;
        Auth::user() -> email = $request -> email;
        Auth::user() -> contacto = $request -> contacto;
        Auth::user() -> save();
        return view('pages.edit_user');
    }
}