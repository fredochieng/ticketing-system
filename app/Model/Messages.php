<?php

namespace App\Model;

use DB;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    public static function getUnsentMessages()
    {
        $messages = DB::table('messages')->where('delivered', '=', 'NO')->orderBy('id', 'asc')->first();
        return $messages;
    }
}