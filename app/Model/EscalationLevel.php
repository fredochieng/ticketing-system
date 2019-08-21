<?php

namespace App\Model;

use Db;
use Illuminate\Database\Eloquent\Model;

class EscalationLevel extends Model
{
    protected $table = 'esc_levels';

    public static function getEscalationLevels()
    {
        $esc_levels = DB::table('roles')
            ->select(
                DB::raw('id'),
                DB::raw('name')
            )
            ->whereIn('id', array(2, 3))
            ->orderBy('id', 'asc')->get();

        return $esc_levels;
    }
}