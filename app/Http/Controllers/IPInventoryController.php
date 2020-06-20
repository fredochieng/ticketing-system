<?php

namespace App\Http\Controllers;

use App\Model\IPInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IPInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ips'] = IPInventory::get_ip_entries();
        return view('inventory/ip.index')->with($data);
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
        $server_name = $request->server_name;
        $server_ip = $request->server_ip;
        $server_username = $request->server_username;
        $server_password = $request->server_password;
        $server_desc = $request->server_desc;
        $server_floor = $request->server_floor;
        $created_by = Auth::user()->id;

        $ip_entry = new IPInventory();
        $ip_entry->server_ip = $server_ip;
        $ip_entry->server_name = $server_name;
        $ip_entry->server_username = $server_username;
        $ip_entry->server_password = $server_password;
        $ip_entry->server_desc = $server_desc;
        $ip_entry->server_floor = $server_floor;
        $ip_entry->created_by = $created_by;

        $ip_entry->save();

        toast('IP entry created  successfully', 'success', 'top-right');

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
    public function destroy($id)
    {
        //
    }
}
