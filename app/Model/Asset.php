<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Asset extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'asset_id'; // or null
    public $incrementing = true;

    public static function getAssets()
    {
        $assets = DB::table('assets')
            ->select(
                DB::raw('assets.*'),
                DB::raw('asset_status.*')
            )
            ->leftJoin('asset_status', 'assets.asset_status', '=', 'asset_status.asset_status_id')
            ->orderBy('asset_id', 'asc')->get();
        return $assets;
    }

    public static function getAssetCategories()
    {
        $asset_categories = DB::table('asset_categories')->orderBy('asset_cat_id', 'asc')->get();
        return $asset_categories;
    }
}
