<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use App\Models\Coa;
use App\Models\Discount;
use App\Models\MenuBom;
use App\Models\Price;
use App\Models\ProblemHandling;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Supplier;
use App\Models\Ticket;
use App\Models\VoidMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function getTicket($data) {
        $data = Crypt::decrypt($data);

        if ($data[0]  == "problem-handling") {
            $ticket = ProblemHandling::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name')->first();
        }
        if ($data[0]  == "permintaan-asset") {
            $ticket = AssetRequest::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "menu-bom") {
            $ticket = MenuBom::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "program-promo") {
            $ticket = Promo::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "discount") {
            $ticket = Discount::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "selisih-harga") {
            $ticket = Price::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "void") {
            $ticket = VoidMenu::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', 'salesMode', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "product") {
            $ticket = Product::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "supplier") {
            $ticket = Supplier::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'ticket.division:id,division_name', "business_unit:id,name_bu")->first();
        }
        if ($data[0]  == "coa") {
            $ticket = Coa::where('ticket_id', $data[1])->with('ticket.subcategory:id,name', 'ticket.approver:id,account_name', 'ticket.handle:id,account_name', 'backoffice:id,backoffice_name')->first();
        }
        
        // return json_encode($ticket);
        $encryptedTicketId = Crypt::encrypt($ticket->ticket_id);

        // Now you can use the encrypted ticket_id as needed
        return response()->json([
            'dataTicket' => $ticket,
            'dataForm' => $encryptedTicketId
        ]);
    }

    public function updateStatus(Request $request, $data) {
        $id = Crypt::decrypt($data);

        $ticket = Ticket::findOrFail($id);

        DB::beginTransaction();

        try {

            if ($ticket->status == "Terkirim") {
                $ticket->status = "Verifikasi";
                $ticket->update();

            } else if ($ticket->status == "Verifikasi") {
                if ($ticket->tipe == "void") {
                    $void = VoidMenu::where('ticket_id', $ticket->id)->first();
                    $void->pin_void = $request->pin_void;
                    $void->save();
                }

                $ticket->approved_by = Auth::user()->id;
                $ticket->status = "Penugasan";

                $ticket->update();

                sendNotifNewTicket("Butuh penanganan",$ticket->id, "penugasan", $ticket->tipe);
            }
            else if ($ticket->status == "Penugasan") {

                $ticket->handle_by = Auth::user()->id;
                $ticket->status = "Pengerjaan";
                $ticket->update();

            } else if ($ticket->status == "Pengerjaan") {

                if ($ticket->tipe == "problem-handling") {
                    $ph = ProblemHandling::where('ticket_id', $ticket->id)->first();
                    $ph->laporan_perbaikan = $request->laporan_perbaikan;
                    $ph->save();
                }
                if ($ticket->tipe == "discount") {
                    $disc = Discount::where('ticket_id', $ticket->id)->first();
                    $disc->diskon_name = json_encode($request->diskon_name);
                    $disc->save();
                }
                if ($ticket->tipe == "void") {
                    $void = VoidMenu::where('ticket_id', $ticket->id)->first();
                    $void->pin_void = $request->pin_void;
                    $void->save();
                }
                
                $ticket->status = "Selesai";
                $ticket->update();
            }
            

            DB::commit();
            
            return back()->with('success', 'Status tiket berhasil diubah.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', $e->getMessage());
            // return back()->with('error', 'Terjadi kesalahan saat mengubah status ticket.');
        }
    }

    public function ticketReject(Request $request) {
        // return $request->all();
        $request->validate([
            'alasan_pembatalan' => "required",
            'ticket_id' => "required",
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        DB::beginTransaction();

        try {
                
            $ticket->status = "Ditolak";
            $ticket->approved_by = Auth::user()->id;
            $ticket->alasan_pembatalan = $request->alasan_pembatalan;
            $ticket->update();

            DB::commit();
            
            return back()->with('success', 'Status tiket berhasil diubah.');
        } catch (\Exception $e) {
            
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat mengubah status ticket.');
        }
    }
}
