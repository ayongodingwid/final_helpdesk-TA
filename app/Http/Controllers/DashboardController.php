<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use App\Models\Backoffice;
use App\Models\Discount;
use App\Models\Price;
use App\Models\ProblemHandling;
use App\Models\Promo;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function dashboardIndex() {
        $tickets = Ticket::whereDate('created_at', today())->orderBy('created_at', 'desc')->take(5)->get();
        $ticketNum = Ticket::whereDate('created_at', today())->count(); 

        $uncomplete = Ticket::whereDate('created_at', today())->whereNot('status', 'Selesai')->count();
        
        $complete = Ticket::whereDate('created_at', today())->where('status', 'Selesai')->count();

        if ($ticketNum == 0) {
            $persentaseSelesai = 0;
        } else {
            $persentaseSelesai = number_format(($complete / $ticketNum) * 100, 0);
        }
        
        $ph = ProblemHandling::whereDate('created_at', today())->count(); 
        $promo = Promo::whereDate('created_at', today())->count(); 
        $sh = Price::whereDate('created_at', today())->count(); 
        $disc = Discount::whereDate('created_at', today())->count(); 
        $aset = AssetRequest::whereDate('created_at', today())->count(); 

        $graph = [$ph, $promo, $sh, $disc, $aset];

        return view('dashboard.index',[
            'ticket' => $ticketNum,
            'tickets' => $tickets,
            'uncomplete' => $uncomplete,
            'persentaseSelesai' => $persentaseSelesai,
            'graph' => $graph
        ]);
    }

    public function listTicket() {
        $tickets = Ticket::leftJoin('ticket_subcategories', 'tickets.ticket_subcategory_id', '=', 'ticket_subcategories.id')
                        ->select('tickets.*', 'ticket_subcategories.name as tsc_name')
                        ->latest()->get();
        return view('dashboard.general.list-ticket', [
            'tickets' => $tickets
        ]);
    }

    public function ticketFilter($id) {
        return $id;
        $tickets = Ticket::where("ticket_number", $id)->get();

        return view('dashboard.general.list-ticket', [
            'tickets' => $tickets
        ]);
    }

}
