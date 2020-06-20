<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use Carbon\Carbon;
use App\adLDAP;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $adldap = new adLDAP();
        $authUser = $adldap->authenticate($username, $password);

        $userinfo = $adldap->user_info($username, array("name", "samaccountname", "userPrincipalName", "mail", "description", "title", "group"));

        // echo "<pre>";
        // print_r($userinfo);
        // exit;
        // dd($userinfo);

        if ($authUser == true) {

            $userinfo = $adldap->user_info($username, array("name", "samaccountname", "userPrincipalName", "mail", "description", "title", "group"));
            // $userinfo=$adldap->user_info($username, array("givenname","sn","title","mail","mobile","info"));
            foreach ($userinfo as $key => $value) {
                $userinfo = $value;
            }


            $user_groups = $adldap->user_groups($username, $recursive = NULL, $isGUID = false);

            $name = $userinfo['name'][0];
            $username = $userinfo['samaccountname'][0];
            //$job_title = $userinfo['description'][0];
            $email = $userinfo['mail'][0];

            if (!array_key_exists('title', $userinfo)) {
                $job_title = '';
            } else {
                $job_title = $userinfo['title'][0];
            }

            $user_names =  User::select('username')->pluck('username')->toArray();

            if (in_array($username, $user_names)) {

                $credentials = $request->only('username', 'password');
                DB::table('users')->where(array('username' => $username))->update(array(
                    'password' => Hash::make($password)
                ));

                if (auth::attempt($credentials, $request->has('remember'))) { //this if validate if the user is on the database line 1

                    return redirect('/home');
                }
            } else {
                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->username = $username;
                $user->job_title = $job_title;
                $user->email_verified_at = Carbon::now();
                $user->password = Hash::make($password);
                $user->save();

                $just_saved_user_id = $user->id;

                $admins = array('fredrick.ochieng');

                // if ($username == 'fredrick.ochieng') {
                //     $role_id = 1;
                // }
                if (in_array($username, $admins)) {
                    $role_id = 1;
                } else {
                    $role_id = 6;
                }
                // SAVE USER ROLE
                $user_role = array(
                    'model_id' => $just_saved_user_id,
                    'model_type' => 'App\User',
                    'role_id' => $role_id
                );
                $save_user_role = DB::table('model_has_roles')->insert($user_role);

                $credentials = $request->only('username', 'password');

                if (auth::attempt($credentials, $request->has('remember'))) {

                    return redirect('/home');
                }
            }
        } else {
            toast('Incorrect username or password', 'warning', 'top-right');
            return back();
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
