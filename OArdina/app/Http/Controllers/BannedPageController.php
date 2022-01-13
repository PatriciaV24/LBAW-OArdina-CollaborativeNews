<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedPageController extends Controller
{
    /**
     * Show Banned User Page
     */
    public function show()
    {      
        return view('pages.banned');
    }
}
