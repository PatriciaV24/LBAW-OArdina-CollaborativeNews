<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /** 
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }


    protected function validator(Request $data){
        $this->validate($data,[
            'username' => 'required|string|max:16|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'required|string|min:9|regex:/[0-9]/',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|confirmed'   
        ]);
    }

    public function register(Request $data){
        $this->validator($data);

        return User::create([
            'username' => $data->username,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'contact' => $data->contact
        ]);
    }
}
?>
