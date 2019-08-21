<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public static function getRoles(){
       $roles = DB::table('roles')->orderBy('id', 'asc')->get();
       return $roles;
    }
}
