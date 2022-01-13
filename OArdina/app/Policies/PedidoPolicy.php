<?php

namespace App\Policies;

use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PedidoPolicy {

	use HandlesAuthorization;

	public function update(Utilizador $user, Pedido $request) {
		return $user -> admin && !($user -> banido);
	}
}