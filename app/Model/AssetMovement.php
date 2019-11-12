<?php

namespace App\Model;

use DB;

use Illuminate\Database\Eloquent\Model;

class AssetMovement extends Model
{
    protected $table = 'assets_movements';

    public static function getAssetMovements()
    {
        $asset_movements = DB::table('assets_movements')
            ->select(
                DB::raw('assets_movements.*'),
                DB::raw('users.id'),
                DB::raw('users.name')
            )
            ->leftJoin('users', 'assets_movements.moved_by', '=', 'users.id')
            ->orderBy('asset_id', 'asc')->get();
        return $asset_movements;
    }
}