<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\AssetSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AssetCategoryController extends Controller
{
    public function index() {

        $categories = AssetCategory::all();

        return view('dashboard.pengaturan.aset.index', [
            'categories' => $categories
        ]);
    }
    
    public function create() {
        return view('dashboard.pengaturan.aset.create');
    }

    public function edit($id) {
        $id = Crypt::decrypt($id);

        $category = AssetCategory::find($id);

        return view('dashboard.pengaturan.aset.edit', [
            'category' => $category
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        DB::beginTransaction();
        
        try {
            
            $ac = new AssetCategory();
            $ac->name = $request->name;
            $ac->code = $request->code;
            $ac->save();
            
            DB::commit();
            
            return redirect(route('pengaturan-aset'))->with('success', 'Kategori berhasil disimpan.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan Kategori.');
        }
    }

    public function update(Request $request, $catId) {
        $id = Crypt::decrypt($catId);

        DB::beginTransaction();
        
        try {
            
            $cat = AssetCategory::findOrFail($id);
            $cat->name = $request->name;
            $cat->code = $request->code;
            $cat->update();
            
            DB::commit();
            
            return back()->with('success', 'Kategori berhasil diupdate.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat mengupdate Kategori.');
        }

    }

    public function delete($id) {
        $id = Crypt::decrypt($id);

        DB::beginTransaction();
        
        try {
            
            AssetSubcategory::where('asset_category_id', $id)->delete();
            AssetCategory::findOrFail($id)->delete();
            
            DB::commit();
            
            return back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus Kategori.');
        }
    }
}
