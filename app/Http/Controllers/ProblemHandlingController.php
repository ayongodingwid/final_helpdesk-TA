<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\ProblemHandling;
use App\Models\Ticket;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProblemHandlingController extends Controller
{
    public function index() {
        $subcategory = TicketSubcategory::where('ticket_category_id', 1)->get();
        $division = Division::all();

        return view('dashboard.ict.penanganan-masalah', [
            'subcategory' => $subcategory,
            'division' => $division,
        ]);
    }

    public function store(Request $request) {
// return $request->all();
        $request->validate([
            'name' => 'required',
            'whatsapp_number' => 'required',
            'ticket_subcategory_id' => 'required',
            'division_id' => 'required',
            
            'location' => 'required',
            'description' => 'required',
            // 'attachment' => 'required'
        ]);
        
        DB::beginTransaction();

        try {

            $ticket = createTicket($request, 'problem-handling');

            $pm = new ProblemHandling();
            $pm->ticket_id = $ticket->id;
            $pm->location = $request->location;
            $pm->description = $request->description;

            // $attachment_path = $request->file('attachment')->store('attachment', 'public');
            // $pm->attachment_path = $attachment_path;
            $pm->save();

            sendNotifNewTicket("Butuh persetujuan",$ticket->id, "persetujuan", $ticket->tipe);
            
            DB::commit();
            
            return back()->with('berhasil', $ticket->ticket_number);
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', $e->getMessage());
            // return back()->with('error', 'Terjadi kesalahan saat membuat tiket.');
        }
    }
}
