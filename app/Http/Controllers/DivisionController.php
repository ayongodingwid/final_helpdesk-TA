<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DivisionController extends Controller
{
    public function index() {

        $divisions = Division::all();
        
        return view('dashboard.master.divisi.index', [
            'divisions' => $divisions
        ]);
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'division_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Division::create($validate);

            DB::commit();

            return redirect(route('divisi'))->with('success', 'Divisi berhasil tersimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('divisi'))->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);
        Division::findOrFail($id)->delete();
        return back()->with('success', 'Divisi berhasil dihapus.');
    }
}
