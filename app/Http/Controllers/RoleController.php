<?php

namespace App\Http\Controllers;
use App\Model\Role;
use DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
