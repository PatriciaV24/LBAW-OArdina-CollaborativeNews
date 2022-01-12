<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\MailtrapExample;


use App\Models\User;
use App\Models\Requests;
use App\Models\PartnerRequest;
use App\Models\ReportUser;
use App\Models\News;
use App\Models\Content;
use App\Models\Follow;
use App\Models\UnbanAppeal;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Shows the user for a given username.
     *
     * @param  string  $username
     * @return view
     */
    public function show($username)
    {
        $this->authorize('viewAny', User::class);

        $user = User::getUser($username);

        if($user == null || $user->is_banned || $user->is_deleted){
            return view('errors.404');
        }

        $posts = $user->news();

        $recentPosts = $posts->sortByDesc('content.date');
        $topPosts = $posts->sortByDesc('content.nr_votes');

        $following = $user->following;

        return view('pages.user', [
            'user' => $user,
            'recentPosts' => $recentPosts,
            'topPosts' => $topPosts,
            'following' => $following
        ]);
    }

    /**
     * Shows the edit page.
     *
     * @param  string  $username
     * @return view
     */
    public function showEditPage($username)
    {
        $user = User::getUser($username);
        $this->authorize('update', $user);
        return view('pages.edit_user', ['minReputation' => User::BECOME_PARTNER]);
    }

    /**
     * Updates user password.
     *
     * @param  Request  $request
     * @return view
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'confirmNewPassword' => 'required|same:newPassword'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if(! Hash::check($request->oldPassword, Auth::user()->password)) {
            return back()->withErrors([
                'oldPassword' => ['The provided password does not match our records.']
            ]);
        }

        Auth::user()->password = bcrypt($request->newPassword);
        Auth::user()->save();

        return view('pages.edit_user');
    }

    /**
     * Updates user information.
     *
     * @param  Request  $request
     * @return view
     */
    public function updateUser(Request $request)
    {
        $this->authorize('update', Auth::user());

        Validator::make($request->all(), [
            'username' => 'required|string|max:16|unique:users,username,'.(string)Auth::id(),
            'email' => 'required|string|email|max:255|unique:users,email,'.(string)Auth::id(),
            'contact' => 'required|string|max:9|unique:users,contact'.(string)Auth::id();
        ])->validate();

        Auth::user()->username = $request->username;
        Auth::user()->email = $request->email;
        Auth::user()->contact = $request->contact;
        Auth::user()->save();
        return view('pages.edit_user');
    }

    /**
     * Updates user as deleted.
     *
     * @param  Request  $request
     * @return view
     */
    public function deleteUser(Request $request)
    {
        $this->authorize('delete', Auth::user());

        if(! Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        Auth::user()->is_deleted = true;
        Auth::user()->save();

        Auth::logout();
        return redirect('/');
    }

    /**
     * Report this User
     */
    public function report(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($request, 400);
        }


        DB::transaction(function () use ($request, $id) {
            // create request
            $db_request = new Requests;

            $db_request->reason = $request->input('body');
            $db_request->from_id = Auth::user()->id;

            $db_request->save();

            $request_id = $db_request->id;

            //create report
            $report = new ReportUser();
            $report->request_id=$request_id;
            $report->to_users_id=$id;

            $report->save();

            return $request_id;
        });

        $response = [
            'status' => true,
            'message' => ""
        ];

        return response()->json($response);
    }

    /**
     * Start Following a User
     */
    public function follow(Request $request){

        $validator = Validator::make($request->all(), [
            'users_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 400);
        }

        Auth::user()->following()->attach($request->users_id);

        $response = [
            'status' => true,
            'message' => "Follow OK",
            'users_id' => $request->users_id
        ];

        return response()->json($response);
    }

    /**
     * Stop Following a User
     */
    public function unfollow(Request $request){

        $validator = Validator::make($request->all(), [
            'users_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator, 400);
        }

        Auth::user()->following()->detach($request->users_id);

        $response = [
            'status' => true,
            'message' => "Unfollow OK",
            'users_id' => $request->users_id
        ];

        return response()->json($response);
    }

    /**
     * Updates unban appeal from this User
     */
    public function unban_appeal(Request $request, $username)
    {

        $user = User::where('username','=',$username)->first();

        User::findOrFail($user->id);

        DB::transaction(function () use ($request, $user) {
            // create request
            $db_request = new Requests;

            $db_request->reason = $request->input('body');
            $db_request->from_id = Auth::user()->id;

            $db_request->save();

            $request_id = $db_request->id;

            //create report
            $unban_appeal = new UnbanAppeal();
            $unban_appeal->request_id=$request_id;
            $unban_appeal->ban_id = $user->currentBan()->id;
            $unban_appeal->save();

            return $unban_appeal;
        });

        return redirect('/ban')->with('success', 'Your unban appeal was registered.');
    }

    /**
     * Ban this User
     */
    function ban(Request $request, $id){
        Validator::make($request->all(), [
            'reason' => 'required|string',
            'end_date' => 'date|after_or_equal:now|required_without:end_date_forever',
            'end_date_forever' => 'required_without:end_date',
        ])->validate();

        $user = User::findOrFail($id);
        $ban_date = $request->input('end_date_forever') ? null : $request->input('end_date');
        $existing_ban = $user->currentBan();
        if(empty($existing_ban)){
            DB::transaction(function () use ($request, $user, $ban_date) {
                $ban = new Ban();
                $ban->users_id = $user->id;
                $ban->admin_id = Auth::user()->id;
                $ban->end_date = $ban_date;
                $ban->reason = $request->input('reason');
                $ban->save();

                $user->is_banned = true;
                $user->save();
                return $ban;
            });
            return redirect('/user/' . $user->username)->with('success', 'Your ban was registered.');
        } else {
            if ($ban_date == null || strtotime($ban_date) > strtotime($existing_ban->end_date)) {
                $existing_ban->admin_id = Auth::user()->id;
                $existing_ban->reason = $request->input('reason');
                $existing_ban->end_date = $ban_date;
                $existing_ban->save();
                return redirect('/user/' . $user->username)->with('success', 'Your ban updated the last one.');
            } else {
                return redirect('/user/' . $user->username)->with('success', 'Already exist a longer ban to this user.');
            }
        }
    }

    /**
     * Send Email to User when he forgets his Password
     */
    public function forgotPassword(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();
        if(!empty($user)){
            $user->recover_pw_id = $user->username . Str::random(40);
            $user->last_recover_pw_time = date('Y-m-d H:i:s');
            $user->save();

            $link = env('APP_URL', 'http://localhost:4321') . "/recover/" . $user->recover_pw_id;
            Mail::to($request->input('email'))->send(new MailtrapExample($user->username, $link));
        
        } else {
            return back()->withErrors([
                'forgot_password' => "User not found!"
            ]);
        }
        return back()->with('success','An email was sent with your new password');
    }

    /**
     * View Recover Password for this User
     */
    public function viewRecoverPassword(Request $request, $id)
    {
        $user = User::where('recover_pw_id', $id)->first();
        if(!empty($user)){
            if(strtotime($user->last_recover_pw_time) > strtotime('-30 minutes')){
                return view('auth.recover_password', ['user' => $user]);
            }
        }
        abort(404);
    }

    /**
     * Recover Password for this User
     */
    public function recoverPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|confirmed',
            'user_id' => 'required'
        ]);

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->recover_pw_id = '';
        $user->save();
        Auth::login($user);
        return redirect('/')->with('success', 'Password changed successfully');
    }
}