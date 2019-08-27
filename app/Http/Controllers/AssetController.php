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
        $data['asset_type'] = 'all';
        $data['asset_status_id'] = 'all';
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
        $data['asset_status_id'] = $asset_status;
        $data['filter'] = 'Y';
        return view('inventory/assets.index')->with($data);
    }

    public function exportSearchedAssetss(Request $request)
    {
        $asset_type = $request->input('asset_type');
        $asset_status = $request->input('asset_status');
        dd($asset_status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['asset_categories'] = Asset::getAssetCategories();
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();
        $data['asset_status'] = DB::table('asset_status')->orderBy('asset_status_id', 'asc')->get();

        return view('inventory.assets/create')->with($data);
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
            $asset_no = strtoupper($request->input('asset_no'));
            $staff_name = strtoupper($request->input('staff_name'));
            $asset_type = strtoupper($request->input('asset_type'));
            $serial_no = strtoupper($request->input('serial_no'));
            $model_no = $request->input('model_no');
            $os = $request->input('os');
            $ram = strtoupper($request->input('ram'));
            $hdd = strtoupper($request->input('hdd'));
            $system_type = $request->input('system_type');
            $processor = $request->input('processor');
            $office = $request->input('office');
            $antivirus = $request->input('antivirus');
            $win_license = $request->input('win_license');
            $country = $request->input('country');

            if (empty($staff_name)) {
                $asset_status = 1;
            } else {
                $asset_status = 3;
            }

            $asset->asset_status = $asset_status;
            $asset->asset_no = $asset_no;
            $asset->staff_name = $staff_name;
            $asset->asset_type = $asset_type;
            $asset->serial_no = $serial_no;
            $asset->model_no = $model_no;
            $asset->os = $os;
            $asset->ram = $ram;
            $asset->hdd = $hdd;
            $asset->system_type = $system_type;
            $asset->processor = $processor;
            $asset->office = $office;
            $asset->antivirus = $antivirus;
            $asset->win_license = $win_license;
            $asset->country = $country;

            $asset->save();

            toast('Asset added successfully', 'success', 'top-right');
            return back();
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
        $status_id = $data['assets']->asset_status;
        $data['assect_categories'] = Asset::getAssetCategories();
        $data['countries'] = DB::table('countries')->orderBy('country_id', 'asc')->get();
        $data['asset_status'] = DB::table('asset_status')->orderBy('asset_status_id', 'asc')->get();
        $status = DB::table('asset_status')->where('asset_status_id', $status_id)->first();
        $data['status_name'] = $status->asset_status_name;
        //dd($data['assets']);
        return view('inventory/assets.manage')->with($data);
    }

    public function changeStatus(Request $request)
    {
        $asset_id = $request->input('asset_id');
        $status_id = $request->input('status_id');
        if ($status_id == 'Unassigned' || $status_id == '1') {
            $status_id = 1;
        } elseif ($status_id == 'Faulty' || $status_id == '2') {
            $status_id = 2;
        } elseif ($status_id == 'Working' || $status_id == '3') {
            $status_id = 3;
        } elseif ($status_id == 'Repair' || $status_id == '4') {
            $status_id = 4;
        }

        if ($status_id == 3) {
            $update_status = Asset::where("asset_id", $asset_id)->update([
                'asset_status' => $status_id
            ]);
        } else {
            $update_status = Asset::where("asset_id", $asset_id)->update([
                'asset_status' => $status_id,
                'staff_name' => ''
            ]);
        }

        toast('Asset status updated successfully', 'success', 'top-right');
        return back();
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
    { }

    public function updateAsset(Request $request)
    {
        $asset_id = $request->input('asset_id');
        $asset_no = strtoupper($request->input('asset_no'));
        $staff_name = strtoupper($request->input('staff_name'));
        $asset_type = strtoupper($request->input('asset_type'));
        $serial_no = strtoupper($request->input('serial_no'));
        $model_no = $request->input('model_no');
        $os = $request->input('os');
        $ram = strtoupper($request->input('ram'));
        $hdd = strtoupper($request->input('hdd'));
        $system_type = $request->input('system_type');
        $processor = $request->input('processor');
        $office = $request->input('office');
        $antivirus = $request->input('antivirus');
        $win_license = $request->input('win_license');
        $country = $request->input('country');

        $update_asset = Asset::where("asset_id", $asset_id)->update([
            'asset_no' => $asset_no,
            'staff_name' => $staff_name,
            'asset_type' => $asset_type,
            'serial_no' => $serial_no,
            'model_no' => $model_no,
            'os' => $os,
            'ram' => $ram,
            'hdd' => $hdd,
            'system_type' => $system_type,
            'processor' => $processor,
            'office' => $office,
            'antivirus' => $antivirus,
            'win_license' => $win_license,
            'country' => $country
        ]);

        toast('Asset details updated successfully', 'success', 'top-right');
        return back();
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