<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Role;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['users'] = DB::table('users')->select(
            DB::raw('users.*'),
            DB::raw('model_has_roles.*'),
            DB::raw('roles.name AS role_name')
        )
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            //->where('model_has_roles.role_id', '!=', 1)
            ->get();
        $data['roles'] = DB::table('roles')->select(DB::raw('roles.*'))->get();

        return view('users/users.index')
            ->with($data);
    }

    public function staff()
    {
        return view('users/staff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:5|max:50',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            Alert::error('New User', 'Oops!!! An error ocurred while adding new user');
            return back();
        } else {
            $user = new User();
            $user->name = strtoupper($request->input('name'));
            $user->email = $request->input('email');
            $password = "wananchihelpdesk";
            $user->password = Hash::make($password);

            DB::beginTransaction();
            $user->save();

            $saved_user_id = $user->id;

            $user_role_data = array(
                'role_id' => $request->role_id,
                'model_type' => "App\User",
                'model_id' => $saved_user_id
            );
            $save_user_role_data = DB::table('model_has_roles')->insertGetId($user_role_data);
            DB::commit();


            $objEmail = new \stdClass();
            $objEmail->contract_code = $final_draft->contract_code;
            $objEmail->title = $final_draft->contract_title;
            $objEmail->subject = 'User Registration';
            $company = "Mediamax Ltd";
            $objEmail->company = $company;

            $message = "You have been added as a/an.";
            $objDemo->email = $final_draft->user_email;
            $objDemo->name = $final_draft->user_name;
            $objDemo->message = $message;

            Alert::success('New User', 'User added successfully');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'string|min:5|max:50',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            Alert::error('Update User', 'Oops!!! An error ocurred while updating user details');
            return back();
        } else {
            $user->name = strtoupper($request->input('name'));

            DB::beginTransaction();
            $user->save();

            $updated_user_id = $user->id;

            $user_role_data = array(
                'role_id' => $request->role_id,
            );
            $save_role_details = DB::table('model_has_roles')->where('model_id', $updated_user_id)->update($user_role_data);

            DB::commit();
            Alert::success('Update User', 'User updated successfully');
            return back();
        }
    }
    public function getUserProfile()
    {
        $user = Auth::user()->id;
        $data['auth_users'] = DB::table('users')
            ->select(
                DB::raw('users.*'),
                DB::raw('users.name AS user_name'),
                DB::raw('model_has_roles.*'),
                DB::raw('roles.name AS role_name')
            )
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', $user)
            ->orderBy('users.id', 'desc')
            ->first();



        return view('users.profile')->with($data);
    }

    public function updateUserProfile(Request $request, user $user)
    {
        // echo $request->input('name');
        //             exit;

        try {
            if (Hash::check($request->input('confirm_password'), $user->password)) {
                $user->email = $request->input('email');

                if (!empty($request->input('password'))) {
                    $user->password = Hash::make($request->input('password'));

                    $user->save();
                }
                $user->name = strtoupper($request->input('name'));
                $user->save();

                $just_updated_user_id = $user->id;

                // $users_details_data = array(
                //     'user_id' => $just_updated_user_id,
                //     'organization_id' => $user->organization_id,
                //     'job_title' => $user->job_title
                // );

                // $update_user_details = DB::table('users_details')->where('user_id', $user->id)->update($users_details_data);
                Alert::success('Profile Update', 'Profile updated successfully');
                return back();
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        }
        Alert::error('Profile Update', 'Your current password is wrong');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        DB::table('users')->where('id', $user->id)->delete();
        Alert::success('Delete User', 'User deleted successfully');
        return back();
    }
}
