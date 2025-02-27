<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\Supplier;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index() {
        $tickets = Supplier::all();

        return view('dashboard.purchasing.supplier.index', [
            'tickets' => $tickets
        ]);
    }

    public function create() {
        $tsc = TicketSubcategory::where('ticket_category_id', 10)->get();
        $division = Division::all();
        $bu = BusinessUnit::all();

        return view('dashboard.purchasing.supplier.create', [
            'tsc' => $tsc,
            'division' => $division,
            'bu' => $bu,
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
            'attachment' => 'required'
        ]);
        
        DB::beginTransaction();

        try {

            $ticket = createTicket($request, 'supplier');

            $supplier = new Supplier();
            $supplier->ticket_id = $ticket->id;
            $supplier->business_unit_id = $request->business_unit_id;
            $supplier->description = $request->description;

            $attachment_path = $request->file('attachment')->store('attachment', 'public');
            $supplier->attachment_path = $attachment_path;
            $supplier->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('supplier'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat membuat tiket.');
        }
    }
}
