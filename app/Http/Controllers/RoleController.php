<?php

namespace App\Http\Controllers;

use App\Model\Role;
use DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Model\Messages;
use App\User;

use Illuminate\Http\Request;

class RoleController extends Controller
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
        $data['roles'] = Role::getRoles();
        return view('users/roles.index')->with($data);
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
    public function store(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|min:4|max:25',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            Alert::error('New Role', 'Oops!!! An error ocurred while adding new role');
            return back();
        } else {
            $role = new Role();
            $role->name = ucwords($request->input('name'));
            $role->guard_name = 'App\User';

            DB::beginTransaction();
            $role->save();
            DB::commit();
            Alert::success('New Role', 'Role added successfully');
            return back();
        }
    }

    public function sendMail(Request $request)
    {
        $users = User::getUsers();
        foreach ($users as $key => $value) {
            # code...
            $message = new Messages();
            $message->title = $request->input('title');
            $message->body = $request->input('body');
            $message->email = $value->email;
            $message->name = $value->name;
            $message->delivered = 'NO';

            $message->save();
        }
        // if ($request->item == "now") {
        //     $message->delivered = 'YES';
        //     $message->send_date = Carbon::now();
        //     $message->save();
        //     $users = User::all();
        //     foreach ($users as $user) {

        //         dispatch(new SendMailsJob($user->email, new UpgradeBreak($user, $message)));
        //     }

        //     return response()->json('Mail sent.', 201);
        // } else {
        //     $message->date_string = '2019-09-03 09:41:00';
        //     $message->save();
        //     return response()->json('Notification will be sent later.', 201);
        // }
        Alert::success('New Role', 'Role added successfully');
        return back();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        DB::table('roles')->where('id', $role->id)->delete();
        Alert::success('Delete Role', 'Role deleted successfully');
        return back();
    }
}
