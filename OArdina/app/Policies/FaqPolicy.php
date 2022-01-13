<?php

namespace App\Policies;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class FaqPolicy {

	use HandlesAuthorization;

	public function create(Utilizador $user) {
		return $user -> admin;
	}

	public function update(Utilizador $user) {
		return $user -> admin;
	}

	public function delete(Utilizador $user) {
		return $user -> admin;
	}
}