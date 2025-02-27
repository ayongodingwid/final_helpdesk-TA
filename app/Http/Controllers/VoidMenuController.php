<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\SalesMode;
use App\Models\TicketSubcategory;
use App\Models\VoidMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoidMenuController extends Controller
{
    public function index() {
        $ticket = VoidMenu::all();

        return view('dashboard.operational.void.index', [
            'ticket' => $ticket,
        ]);
    }
    
    public function create() {
        $sm = SalesMode::all();
        $bu = BusinessUnit::all();
        $tsc = TicketSubcategory::where('ticket_category_id', 7)->first();

        return view('dashboard.operational.void.create', [
            'bu' => $bu,
            'tsc' => $tsc,
            'sm' => $sm
        ]);
    }

    public function store(Request $request) {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            // 'division_id' => 'required',
            'business_unit_id' => 'required',
            'outlet_name' => 'required',
            'sales_mode_id' => 'required',
            'transaction_no' => 'required',
            'reason_void' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $ticket = createTicket($request, "void");

            $void = new VoidMenu();
            $void->ticket_id = $ticket->id;
            $void->business_unit_id = $request->business_unit_id;
            $void->outlet_name = $request->outlet_name;
            $void->sales_mode_id = $request->sales_mode_id;
            $void->transaction_no = $request->transaction_no;
            $void->reason_void = $request->reason_void;
            $void->save();

            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('void'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', "Terjadi kesalahan saat membuat tiket.");
        }
    }
}
