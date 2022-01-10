<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller {

	public function show() {

		return view('pages.banned');
	
	}
}