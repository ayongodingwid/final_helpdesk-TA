<?php

use App\Models\Notification;
use App\Models\Ticket;
use App\Models\TicketSubcategory;
use Illuminate\Support\Facades\Auth;

if (! function_exists('generateTicketNumber')) {

    function generateTicketNumber($tipe, $subCat_id) {

        if ($tipe == "ticket") {
            $subCategory_id = TicketSubcategory::find($subCat_id);
            $head = "R";
            $category = $subCategory_id->ticketCategory->code;
            $subCategory = $subCategory_id->code;
        } else {
            $head = "A";
        }

        $ticket_order = Ticket::whereDate('created_at', today())->count();
        $order = $ticket_order + 1;
        $order = $order <= 9 ? "0".$order : $order;
                
        $ticket_number = $head.$category.$subCategory.today()->format('dmY').$order ;
        
        return $ticket_number;
    }
}

if (! function_exists('createTicket')) {

    function createTicket($request, $tipe) {

        $ticket = new Ticket();
        $ticket->name = $request->name;
        $ticket->ticket_number = generateTicketNumber('ticket', $request->ticket_subcategory_id);
        $ticket->whatsapp_number = $request->whatsapp_number;
        if ($request->division_id) {
            $ticket->division_id = $request->division_id;
        }
        $ticket->ticket_subcategory_id = $request->ticket_subcategory_id;
        $ticket->tipe = $tipe;
        if ($tipe == 'permintaan-asset') {
            $ticket->status = "Terkirim";
        }
        $ticket->save();

        return $ticket;
    }
}
if (! function_exists('sendNotifNewTicket')) {

    function sendNotifNewTicket($m, $tId, $tujuan, $type) {

        $notif = new Notification();
        $notif->message = $m;
        $notif->ticket_id = $tId;
        $notif->tujuan = $tujuan;
        $notif->ticket_type = $type;
        // $notif->user_id = $user_id;
        
        $notif->save();
    }
}