<?php

namespace App\Policies;

use App\Models\Utilizador;
use Illuminate\Auth\Acess\HandlesAuthorization;

class UtilizadorPolicy {
    
    use HandlesAuthorization;

    public function viewAny(Utilizador $eu) {

        return !($eu->permissao == 'b');

    }

    public function view(Utilizador $eu, Utilizador $user) {
        return !($eu -> permissao == 'b');
    }

    public function update(Utilizador $eu, Utilizador $user) {
        return ($eu -> id === $user -> id);
    }

}