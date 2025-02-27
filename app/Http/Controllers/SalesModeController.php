<?php

namespace App\Http\Controllers;

use App\Models\SalesMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SalesModeController extends Controller
{
    public function index() {

        $sales = SalesMode::all();
        
        return view('dashboard.master.sales-mode.index', [
            'sales' => $sales
        ]);
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'sales_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            SalesMode::create($validate);

            DB::commit();

            return redirect(route('sales-mode'))->with('success', 'Mode penjualan berhasil tersimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('sales-mode'))->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);
        SalesMode::findOrFail($id)->delete();
        return back()->with('success', 'Mode penjualan berhasil dihapus.');
    }
}
