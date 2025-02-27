<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\Price;
use App\Models\SalesMode;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function index() {
        $ticket = Price::all();

        return view('dashboard.operational.selisih-harga.index', [
            'ticket' => $ticket
        ]);
    }
    
    public function create() {
        $sm = SalesMode::all();
        $divisi = Division::all();
        $bu = BusinessUnit::all();
        $tsc = TicketSubcategory::where('ticket_category_id', 6)->first();

        return view('dashboard.operational.selisih-harga.create', [
            'divisi' => $divisi,
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
            'menu_name' => 'required',
            'price_pos' => 'required',
            'price_salesmode' => 'required',
            'tax_status' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $ticket = createTicket($request, "selisih-harga");

            $disc = new Price();
            $disc->ticket_id = $ticket->id;
            $disc->business_unit_id = $request->business_unit_id;
            $disc->outlet_name = $request->outlet_name;
            $disc->sales_mode = json_encode($request->sales_mode);
            $disc->menu_name = json_encode($request->menu_name);
            $disc->price_pos = json_encode($request->price_pos);
            $disc->price_salesmode = json_encode($request->price_salesmode);
            $disc->tax_status = json_encode($request->tax_status);
            $disc->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('harga'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', "Terjadi kesalahan saat membuat tiket.");
        }
    }
}
