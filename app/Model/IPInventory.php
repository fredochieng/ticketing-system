<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IPInventory extends Model
{
    protected $table = 'ip_inventory';

    public static function get_ip_entries()
    {
        $ips = DB::table('ip_inventory')->select(
            DB::raw('ip_inventory.*'),
            DB::raw('ip_inventory.id as server_id')
        )
            ->orderBy('ip_inventory.id', 'asc')
            ->get();

        return $ips;
    }
}
// https://www.spidermetrix.com/projects/15/v191intro.php?src=119&prj=204377&pid=XXXXXX