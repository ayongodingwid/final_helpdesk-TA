<?php

namespace App\Http\Controllers;

use App\Models\Backoffice;
use App\Models\Coa;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoaController extends Controller
{
    public function index() {
        $tickets = Coa::all();

        return view('dashboard.fat.coa.index', [
            'tickets' => $tickets
        ]);
    }

    public function create() {
        $tsc = TicketSubcategory::where('ticket_category_id', 8)->first();
        $system = Backoffice::all();

        return view('dashboard.fat.coa.create', [
            'tsc' => $tsc,
            'system' => $system,
        ]);
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            
            'backoffice_id' => 'required',
            'coa_no' => 'required',
            'coa_name' => 'required'
        ]);
        
        DB::beginTransaction();

        try {

            $ticket = createTicket($request, 'coa');

            $coa = new Coa();
            $coa->ticket_id = $ticket->id;
            $coa->backoffice_id = $request->backoffice_id;
            $coa->coa_name = json_encode($request->coa_name);
            $coa->coa_no = json_encode($request->coa_no);
            $coa->save();

            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);
            DB::commit();
            
            return redirect(route('coa'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', $e->getMessage());
            // return back()->with('error', 'Terjadi kesalahan saat membuat tiket.');
        }
    }
}
