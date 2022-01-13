<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class DeletedController extends Controller
{
    /**
     * Shows form to recover deleted account.
     *
     * @return view
     */
    public function show()
    {
        return view('pages.deleted');
    }

    /**
     * Revocer deleted account.
     *
     * @param Request $request
     * @return view
     */
    public function recoverUser(Request $request){
        $this->authorize('update', Auth::user());

        if(! Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        Auth::user()->is_deleted = false;
        Auth::user()->save();

        return redirect('/');
    }
}
