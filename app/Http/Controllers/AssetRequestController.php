<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use App\Models\BusinessUnit;
use App\Models\Division;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AssetRequestController extends Controller
{
    public function index() {
        $tickets = AssetRequest::all();

        return view('dashboard.ict.permintaan-aset.index', [
            'tickets' => $tickets,
        ]);
    }
    public function create() {
        $division = Division::all();
        $bu = BusinessUnit::all();
        $data = TicketSubcategory::where('ticket_category_id', 2)->first();

        return view('dashboard.ict.permintaan-aset.create', [
            'division' => $division,
            'bu' => $bu,
            'data' => $data
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            'division_id' => 'required',
            'business_unit_id' => 'required',
            'asset_name' => 'required',
            'quantity' => 'required',
            'asset_receiver' => 'required',
            'asset_receiver_position' => 'required',
            'position' => 'required',
            'description' => 'required',
            'note' => 'required',
            'expectation' => 'required',
        ]);
        
        DB::beginTransaction();

        try {

            $ticket = createTicket($request, 'permintaan-asset');

            $ar = new AssetRequest();
            $ar->ticket_id = $ticket->id;
            $ar->asset_name = json_encode($request->asset_name);
            $ar->quantity = json_encode($request->quantity);
            $ar->asset_receiver = json_encode($request->asset_receiver);
            $ar->asset_receiver_position = json_encode($request->asset_receiver_position);
            $ar->position = json_encode($request->position);
            $ar->business_unit_id = $request->business_unit_id;
            $ar->description = $request->description;
            $ar->note = $request->note;
            $ar->expectation = $request->expectation;

            $ar->save();
            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);

            DB::commit();
            
            return redirect(route('ict-pa'))->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function getForm($id) {
        $id = Crypt::decrypt($id);
        $req = AssetRequest::where('ticket_id',$id)->first();

        return view("dashboard.ict.permintaan-aset.reqaset", [
            'req' => $req
        ]);
    }
}
