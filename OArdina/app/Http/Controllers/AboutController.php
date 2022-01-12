<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
    * Show About Page
    */
    public function show()
    {      
        return view('pages.about');
    }
}