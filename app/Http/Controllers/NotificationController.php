<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotification() {

        $userNotifications = Notification::where('user_id', Auth::user()->id)
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

        $notifications = $userNotifications;

        if (in_array('approve', json_decode(Auth::user()->role->permission->penanganan_masalah_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'problem-handling')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->pengajuan_aset_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'permintaan-aset')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->menu_bom_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'menu-bom')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->program_promo_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'program-promo')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->diskon_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'discount')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->selisih_harga_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'selidih-harga')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->void_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'void')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->coa_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'coa')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->product_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'product')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('approve', json_decode(Auth::user()->role->permission->supplier_option))) {
            $approvalNotifications = Notification::where('tujuan', "persetujuan")
                                        ->where('ticket_type', 'supplier')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }

        // STAFF
        if (in_array('update', json_decode(Auth::user()->role->permission->penanganan_masalah_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'problem-handling')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->pengajuan_aset_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'permintaan-aset')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->menu_bom_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'menu-bom')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->program_promo_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'program-promo')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->diskon_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'discount')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->selisih_harga_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'selidih-harga')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->void_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'void')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->coa_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'coa')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->product_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'product')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }
        if (in_array('update', json_decode(Auth::user()->role->permission->supplier_option))) {
            $approvalNotifications = Notification::where('tujuan', "penugasan")
                                        ->where('ticket_type', 'supplier')
                                        ->where('read_status', 0)
                                        ->with('ticket:id,ticket_number')->get();

            $notifications = $notifications->merge($approvalNotifications);
        }

        return response()->json($notifications);
    }

    public function readAll(Request $request) {

        $data = explode(",", $request->data);

        foreach ($data as $key => $value) {
            $notif = Notification::findOrFail($value);
            $notif->read_status = 1;
            $notif->update();
        }
        
        return back();
    }

    public function readNotif(Request $request) {

        $notif = Notification::findOrFail($request->data);
        $notif->read_status = 1;
        $notif->update();
        
        return redirect(route('list-ticket'));
    }

}
