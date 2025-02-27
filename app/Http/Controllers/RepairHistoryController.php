<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\RepairHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RepairHistoryController extends Controller
{
    public function create($idAsset) {
        $id = Crypt::decrypt($idAsset);

        $asset = Asset::findOrFail($id);

        return view("dashboard.master.aset.repair.create", [
            'asset' => $asset
        ]);
    }

    public function history() {
        $logs = RepairHistory::all();
        
        return view("dashboard.master.aset.repair.history", [
            'logs' => $logs
        ]);
    }

    public function store(Request $request) {

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'asset_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $data['user_repair'] = Auth::user()->id;

            RepairHistory::create($data);

            DB::commit();
            
            return redirect(route('asset-detail', Crypt::encrypt($request->asset_id)))->with('success', "Data perbaikan berhasil disimpan.");
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function getRepairHistory($data) {
        $data = RepairHistory::findOrFail($data);

        return response()->json($data);
    }
}
