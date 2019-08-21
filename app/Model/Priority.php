<?php

namespace App\Model;
use DB;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'ticket_priority';
    public static function getPriorities(){
        $priorities = DB::table('ticket_priority')->orderBy('priority_id', 'asc')->get();
        return $priorities;
    }
}
