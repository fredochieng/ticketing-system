<?php

namespace App\Http\Controllers;

use App\Model\Asset;
use App\Model\Category;
use Illuminate\Http\Request;
use DB;

class AssetController extends Controller
{
    // http://74.220.219.210:2082
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['assets'] = Asset::getAssets();
        $data['assect_categories'] = Asset::getAssetCategories();
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();
        $data['asset_status'] = DB::table('asset_status')->orderBy('asset_status_id', 'asc')->get();
        $data['filter'] = 'N';
        //dd($data['assets']);
        return view('inventory/assets.index')->with($data);
    }

    public function getSearchedAssets(Request $request)
    {
        $asset_type = $request->input('category_name');
        $asset_status = $request->input('asset_status_id');
        $data['assets'] = Asset::getAssets()
            ->where('asset_type', $asset_type)
            ->where('asset_status', $asset_status);
        $data['assect_categories'] = Asset::getAssetCategories();
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();
        $data['asset_status'] = DB::table('asset_status')->orderBy('asset_status_id', 'asc')->get();
        $data['asset_type'] = $asset_type;
        $data['filter'] = 'Y';
        return view('inventory/assets.index')->with($data);
        // echo "<pre>";
        // print_r($data['assets']);
        // exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('category_name', 'id')->all();
        $asset_status = DB::table('asset_status')->pluck('status_name', 'id')->all();
        $manufacturers = DB::table('manufacturers')->pluck('manufacturer_name', 'manufacturer_id')->all();
        $models = DB::table('models')->pluck('model_name', 'model_id')->all();
        $os = DB::table('os')->pluck('os_name', 'os_id')->all();
        $system_types = DB::table('system_types')->pluck('system_type_name', 'system_type_id')->all();
        $processors = DB::table('processors')->pluck('processor_name', 'processor_id')->all();
        $ram = DB::table('ram')->pluck('ram_name', 'ram_id')->all();
        $hdd = DB::table('hdd')->pluck('hdd_size', 'hdd_id');
        $office = DB::table('office')->pluck('office_name', 'office_id')->all();
        $windows_licence = DB::table('windows_licence')->pluck('licence_name', 'licence_id')->all();
        $users = DB::table('users')->pluck('name', 'id')->all();

        return view('inventory/assets.create')
            ->with([
                'categories' => $categories,
                'asset_status' => $asset_status,
                'manufacturers' => $manufacturers,
                'models' => $models,
                'os' => $os,
                'system_types' => $system_types,
                'processors' => $processors,
                'ram' => $ram,
                'hdd' => $hdd,
                'office' => $office,
                'windows_licence' => $windows_licence,
                'users' => $users
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $this->validate($request, [
                'asset_no' => 'required'
                // 'category_id' => 'required',
                // 'model' => 'required',
                // 'serial_no' => 'required',
            ]);
            $asset = new Asset();
            $asset_tag = "WG";
            $asset_num = $request->asset_no;
            $asset_number = $asset_tag . $asset_num;
            $asset->asset_no = $asset_number;
            $asset->model = $request->model;
            $asset->category_id = $request->category_id;
            $asset->serial_no = $request->serial_no;
            // $asset->os_id = $request->os_id;
            // $asset->system_type_id = $request->system_type_id;
            // $asset->processor_id = $request->processor_id;
            // $asset->ram_id = $request->ram_id;
            // $asset->hdd_id = $request->hdd_id;
            // $asset->office_id = $request->office_id;
            // $asset->windows_licence_id = $request->licence_id;
            $asset->user_id = $request->user_id;

            // Get the last created order
            $lastOrder = Asset::orderBy('created_at', 'desc')->first();

            if (!$lastOrder)
                //     // We get here if there is no order at all
                //     // If there is no number set it to 0, which will be 1 at the end.

                $number = 0;
            else
                $number = substr($lastOrder->asset_no, 3);
            // $number = 000;

            // If we have ORD000001 in the database then we only want the number
            // So the substr returns this 000001

            // Add the string in front and higher up the number.
            // the %05d part makes sure that there are always 6 numbers in the string.
            // so it adds the missing zero's when needed.

            return 'ORD' . sprintf('%03d', intval($number) + 1);
            echo "<pre>";
            print_r($number);
            exit;

            DB::beginTransaction();
            $asset->save();

            $saved_asset_id = $asset->id;

            $asset_details_data = array();

            DB::commit();

            return response()->json(['success' => 'Asset successfully added']);
            return redirect('inventory/assets/create');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['error' => 'Asset not saved']);
            return redirect('inventory/assets/create');
        }
    }

    public function manageAsset($asset_id = null)
    {
        $data['assets'] = Asset::getAssets()
            ->where('asset_id', $asset_id)->first();
        //dd($data['assets']);
        return view('inventory/assets.manage')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }
}