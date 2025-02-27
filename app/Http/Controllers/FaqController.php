<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index() {
        $faqs = Faq::all();

        return view('dashboard.pengaturan.faq.index', [
            'faqs' => $faqs
        ]);
    }

    public function create() {
        return view('dashboard.pengaturan.faq.create');
    }

    public function edit($id) {
        $faq = Faq::findOrFail($id);

        return view('dashboard.pengaturan.faq.edit', [
            'faq' => $faq
        ]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'detail' => 'required',
        ]);
        
        DB::beginTransaction();
        
        try {
            $data['status'] = 'Aktif';

            Faq::create($data);

            DB::commit();

            return redirect(route('faq'))->with('success', 'Faq berhasil dibuat.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'title' => 'required',
            'detail' => 'required',
        ]);
        
        DB::beginTransaction();
        
        try {
            $data['status'] = 'Aktif';

            Faq::findOrFail($id)->update($data);

            DB::commit();

            return back()->with('success', 'Faq berhasil di ubah.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengubah data.');
        }
    }

    public function destroy($id) {
        
        DB::beginTransaction();
        
        try {
            Faq::findOrFail($id)->delete();

            DB::commit();

            return back()->with('success', 'Faq berhasil di hapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
