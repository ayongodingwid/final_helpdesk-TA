<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\MenuBom;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuBomController extends Controller
{
    public function index() {

        $ticket = MenuBom::all();

        return view('dashboard.operational.menu-bom.index', [
            'ticket' => $ticket
        ]);
    }
    
    public function create() {

        $divisi = Division::all();
        $bu = BusinessUnit::all();
        $tsc = TicketSubcategory::where('ticket_category_id', 3)->get();

        return view('dashboard.operational.menu-bom.create', [
            'divisi' => $divisi,
            'bu' => $bu,
            'tsc' => $tsc
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            'division_id' => 'required',
            'business_unit_id' => 'required',
            'description' => 'required',
            'attachment' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $ticket = createTicket($request, "menu-bom");

            $mnb = new MenuBom();
            $mnb->ticket_id = $ticket->id;
            $mnb->business_unit_id = $request->business_unit_id;
            $mnb->description = $request->description;

            $attachment_path = $request->file('attachment')->store('attachment', 'public');
            $mnb->attachment_path = $attachment_path;
            $mnb->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('menu-bom'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat membuat tiket.');
        }
    }
}
