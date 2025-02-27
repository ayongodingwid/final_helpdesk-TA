<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Faq;
use App\Models\Ticket;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LandingPageController extends Controller
{
    
    public function index() {
        $faqs = Faq::all();

        return view('landing-page.index', [
            'faqs' => $faqs,
        ]);
    }

    public function createTicket() {
        $subcategory = TicketSubcategory::where('ticket_category_id', 1)->get();
        $division = Division::all();

        return view('landing-page.ticket-create', [
            'subcategory' => $subcategory,
            'division' => $division,
        ]);
    }

    // public function detailTicket($ticket_number) {
    //     $ticket = Ticket::where("ticket_number", $ticket_number)->first();
        
    //     return view('landing-page.ticket-detail', [
    //         'ticket' => $ticket
    //     ]);
    // }

    public function searchTicket(Request $request) {
        $query = $request->code;

        $ticket = Ticket::where('tipe', 'problem-handling')->where('ticket_number', $query)->first();
        
        // return $ticket;

        if ($ticket) {
            return view('landing-page.ticket-detail', [
                'ticket' => $ticket
            ]);
        } else {
            return back()->with('error','Tiket dengan nomor "'.$query.'" tidak ditemukan.');
        }
        
    }
}
