<?php

namespace App\Http\Controllers;

use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TicketSubcategoryController extends Controller
{
    public function delete($id) {
        $tsc = TicketSubcategory::findOrfail($id)->delete();

        if ($tsc) {
            return back()->with('success', "Sub kategori tiket berhasil dihapus.");
        } else {
            return back()->with('error', 'Terjadi kesalahan saat menghapus sub kategori tiket.');
        }

    }
}
