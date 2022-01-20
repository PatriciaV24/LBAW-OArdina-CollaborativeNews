<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
    * Show Contacts Page
    */
    public function show()
    {      
        return view('pages.contacts');
    }
}
