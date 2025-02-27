<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BusinessUnitController extends Controller
{
    public function index() {

        $bUnits = BusinessUnit::all();
        
        return view('dashboard.master.bisnis-unit.index', [
            'bUnits' => $bUnits
        ]);
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'name_bu' => 'required',
            'code' => 'required',
        ]);

        DB::beginTransaction();
        try {
            BusinessUnit::create($validate);

            DB::commit();

            return redirect(route('bisnis-unit'))->with('success', 'Bisnis unit berhasil tersimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('bisnis-unit'))->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);
        BusinessUnit::findOrFail($id)->delete();
        return back()->with('success', 'Bisnis unit berhasil dihapus.');
    }
}
