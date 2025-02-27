<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TicketCategoryController extends Controller
{
    public function index() {

        $categories = TicketCategory::all();

        return view('dashboard.pengaturan.ticket.index', [
            'categories' => $categories
        ]);
    }
    
    public function create() {
        return view('dashboard.pengaturan.ticket.create');
    }

    public function edit($id) {
        $id = Crypt::decrypt($id);

        $category = TicketCategory::find($id);

        return view('dashboard.pengaturan.ticket.edit', [
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
            
            $tc = new TicketCategory();
            $tc->name = $request->name;
            $tc->code = $request->code;
            $tc->save();

            if($request->sub && $request->subCode) {
                foreach ($request->sub as $key => $value) {
                    if ($request->sub[$key] != null && $request->subCode[$key] != null) {
                        $tsc = new TicketSubcategory();
                        $tsc->name = $request->sub[$key];
                        $tsc->code = $request->subCode[$key];
                        $tsc->approval_status = false;
                        $tsc->ticket_category_id = $tc->id;
                        $tsc->save();
                    }
                }
            }
            
            DB::commit();
            
            return redirect(route('pengaturan-ticket'))->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus Kategori.');
        }
    }

    public function update(Request $request, $catId) {
        $id = Crypt::decrypt($catId);

        DB::beginTransaction();

        try {
            
            $cat = TicketCategory::findOrFail($id);
            $cat->name = $request->name;
            $cat->code = $request->code;
            $cat->update();

            if ($request->sub && $request->subCode) {

                foreach ($request->sub as $key => $value) 
                {
                    if ($request->sub[$key] != null && $request->subCode[$key] != null) 
                    {
                        $data = explode(',', $request->sub[$key]);

                        if (count($data) >= 2) {
                            $tscId = Crypt::decrypt($data[1]);
                            $tsc = TicketSubcategory::findOrFail($tscId);
                            $tsc->name = $request->subName[$key];
                            $tsc->code = $request->subCode[$key];
                            $tsc->update();

                        } else {
                            $tsc = new TicketSubcategory();
                            $tsc->name = $data[0];
                            $tsc->code = $request->subCode[$key];
                            $tsc->approval_status = false;
                            $tsc->ticket_category_id = $id;
                            $tsc->save();
                        }
                    }
                }
            }
            
            DB::commit();
            
            return back()->with('success', 'Kategori berhasil di update.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat mengupdate Kategori.');
        }
    }

    public function delete($id) {
        $id = Crypt::decrypt($id);

        DB::beginTransaction();
        
        try {
            
            TicketSubcategory::where('ticket_category_id', $id)->delete();
            TicketCategory::findOrFail($id)->delete();
            
            DB::commit();
            
            return back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus Kategori.');
        }
    }
}
