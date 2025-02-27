<?php

namespace App\Http\Controllers;

use App\Models\Backoffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class BackofficeController extends Controller
{
    public function index() {

        $backoffice = Backoffice::all();
        
        return view('dashboard.master.backoffice.index', [
            'backoffice' => $backoffice
        ]);
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'backoffice_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            Backoffice::create($validate);

            DB::commit();

            return redirect(route('backoffice'))->with('success', 'Backoffice berhasil tersimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('backoffice'))->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);
        Backoffice::findOrFail($id)->delete();
        return back()->with('success', 'Backoffice berhasil dihapus.');
    }
}
