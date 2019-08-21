<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    public static function getDepartments(){
        $departments = DB::table('departments')->orderBy('department_id', 'asc')->get();
        return $departments;
    }
}
