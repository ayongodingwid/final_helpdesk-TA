<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Discount;
use App\Models\Division;
use App\Models\SalesMode;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index() {
        $ticket = Discount::all();

        return view('dashboard.operational.discount.index', [
            'ticket' => $ticket
        ]);
    }
    
    public function create() {
        $sm = SalesMode::all();
        $bu = BusinessUnit::all();
        $tsc = TicketSubcategory::where('ticket_category_id', 5)->first();

        return view('dashboard.operational.discount.create', [
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
            'sales_mode' => 'required',
            'tipe' => 'required',
            'nominal' => 'required',
            'tax_status' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $ticket = createTicket($request, "discount");

            $disc = new Discount();
            $disc->ticket_id = $ticket->id;
            $disc->business_unit_id = $request->business_unit_id;
            $disc->outlet_name = $request->outlet_name;
            $disc->sales_mode = json_encode($request->sales_mode);
            $disc->tipe = json_encode($request->tipe);
            $disc->nominal = json_encode($request->nominal);
            $disc->tax_status = json_encode($request->tax_status);
            $disc->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('discount'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', "Terjadi kesalahan saat membuat tiket.");
        }
    }
}
