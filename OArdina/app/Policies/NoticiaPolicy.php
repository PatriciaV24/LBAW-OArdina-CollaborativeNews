<?php

namespace App\Policies;

use App\Models\Noticia;
use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NoticiaPolicy {

    use HandlesAuthorization;

    public function viewAny(Utilizador $user) {
        return !($user->permissao == 'b');
    }


    public function view (?Utilizador $user, Noticia $noticia) {

        if($noticia -> autor -> permissao == 'b') {
            return Response::deny('O utilizador que criou este post encontra-se banido');
        }
        else {
            return!(optional($user)->permissao == 'b');
        }
    }

    public function create(Utilizador $user) {
        return !($user->permissao == 'b');
    }

    public function update(Utilizador $user, Noticia $noticia) {
        return $user->id === $noticia->autor_id && !($user->permissao =='b');
    }

    public function delete(Utilizador $user, Noticia $noticia) {
        return($user->id === $noticia->autor_id && !($user->permissao == 'b') || ($user->permissao == 'a'));
    }
}