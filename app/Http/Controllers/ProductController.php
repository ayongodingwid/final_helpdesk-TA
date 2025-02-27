<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\Product;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $tickets = Product::all();

        return view('dashboard.purchasing.product.index', [
            'tickets' => $tickets
        ]);
    }

    public function create() {
        $tsc = TicketSubcategory::where('ticket_category_id', 9)->get();
        $division = Division::all();
        $bu = BusinessUnit::all();

        return view('dashboard.purchasing.product.create', [
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

            $ticket = createTicket($request, 'product');

            $product = new Product();
            $product->ticket_id = $ticket->id;
            $product->business_unit_id = $request->business_unit_id;
            // $product->division_id = $request->division_id;
            $product->description = $request->description;

            $attachment_path = $request->file('attachment')->store('attachment', 'public');
            $product->attachment_path = $attachment_path;
            $product->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('product'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat membuat tiket.');
        }
    }
}
