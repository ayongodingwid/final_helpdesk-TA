<?php

namespace App\Http\Controllers;

use App\Models\AssetSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AssetSubcategoryController extends Controller
{
    public function delete($id) {
        $asc = AssetSubcategory::findOrfail($id)->delete();

        if ($asc) {
            return back()->with('success', "Sub kategori aset berhasil dihapus.");
        } else {
            return back()->with('error', 'Terjadi kesalahan saat menghapus sub kategori aset.');
        }
    }
}
