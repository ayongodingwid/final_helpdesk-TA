<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\BusinessUnit;
use App\Models\RepairHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index() {
        $asset = Asset::all();
        
        return view('dashboard.master.aset.index', [
            'asset' => $asset
        ]);
    }

    public function show($id) {
        $id = Crypt::decrypt($id);
        $asset = Asset::findOrFail($id);
        $ac = AssetCategory::all();
        $bu = BusinessUnit::all();

        $repair = RepairHistory::where('asset_id', $id)->get();

        return view('dashboard.master.aset.show', [
            'repair' => $repair,
            'asset' => $asset,
            'ac' => $ac,
            'bu' => $bu
        ]);
    }

    public function create() {
        $ac = AssetCategory::all();
        $bu = BusinessUnit::all();

        return view('dashboard.master.aset.create',[
            'ac' => $ac,
            'bu' => $bu
        ]);
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'asset_category_id' => "required",
            'asset_name' => "required",
            'buy_date' => "required",
            'buy_price' => "required",
            'status' => "required",
            'business_unit_id' => "required",
            'user' => "required",
            'departemen' => "required",
            'position_employee' => "required",
            'level_employee' => "required",
            'specification' => "required",
            'notes' => "required",
        ]);

        $validatedData['no_idasset'] = $this->idGenerate($request->asset_category_id, $request->business_unit_id);

        DB::beginTransaction();
        
        try {
            Asset::create($validatedData);

            DB::commit();

            return redirect(route('asset'))->with('berhasil', $validatedData['no_idasset']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $idAsset) {

        $id = Crypt::decrypt($idAsset);

        $asset = Asset::findOrFail($id);

        $validatedData = $request->validate([
            'asset_category_id' => "required",
            'asset_name' => "required",
            'buy_date' => "required",
            'buy_price' => "required",
            'status' => "required",
            'business_unit_id' => "required",
            'user' => "required",
            'departemen' => "required",
            'position_employee' => "required",
            'level_employee' => "required",
            'specification' => "required",
            'notes' => "required",
        ]);

        $validatedData['no_idasset'] = $asset->no_idasset;

        DB::beginTransaction();
        
        try {
            
            $asset->update($validatedData);

            DB::commit();

            return back()->with('success', "Data aset berhasil diubah.");
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function idGenerate($acId, $buId) {
        $ac = AssetCategory::findOrfail($acId);
        $bu = BusinessUnit::findOrfail($buId);
        
        $asset_order = Asset::whereDate('created_at', today())->count();
        $order = $asset_order + 1;
        $order = $order <= 9 ? "0".$order : $order;

        $idAsset = "A". $ac->code.$bu->code.today()->format('dmY').$order;
        return $idAsset;
    }
}
