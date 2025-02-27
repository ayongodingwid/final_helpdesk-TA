<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\Promo;
use App\Models\SalesMode;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    public function index() {
        $ticket = Promo::all();

        return view('dashboard.operational.program-promo.index', [
            'ticket' => $ticket
        ]);
    }
    
    public function create() {

        $divisi = Division::all();
        $bu = BusinessUnit::all();
        $sales = SalesMode::all();
        $tsc = TicketSubcategory::where('ticket_category_id', 4)->first();

        return view('dashboard.operational.program-promo.create', [
            'divisi' => $divisi,
            'bu' => $bu,
            'tsc' => $tsc,
            'sales' => $sales
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            'division_id' => 'required',
            'name_program' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'sales_mode_id' => 'required',
            'business_unit_id' => 'required',
            'description' => 'required',
            'attachment' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $ticket = createTicket($request, "program-promo");
            $mnb = new Promo();
            $mnb->ticket_id = $ticket->id;
            $mnb->business_unit_id = $request->business_unit_id;
            $mnb->name = $request->name_program;
            $mnb->date_start = $request->date_start;
            $mnb->date_end = $request->date_end;
            $mnb->promo_status = 'Nonaktif';
            $mnb->sales_mode_id = $request->sales_mode_id;
            $mnb->description = $request->description;

            $attachment_path = $request->file('attachment')->store('attachment', 'public');
            $mnb->attachment_path = $attachment_path;
            $mnb->save();

            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);
            
            DB::commit();
            
            return redirect(route('program-promo'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', "Terjadi kesalahan saat membuat tiket.");
        }
    }
    
}
