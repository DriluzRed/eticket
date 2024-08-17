<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class QrController extends Controller
{
    public function scan()
    {
        return view('pages.qr.scan');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string',
        ]);

        $ticket = Ticket::where('qr_code', $validated['qr_code'])->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket no encontrado']);
        }

        if ($ticket->confirmed) {
            return response()->json(['warning' => 'El ticket ya fue utilizado']);
        }

        $ticket->confirmed = true;
        $ticket->save();
        $data = [
            'name' => $ticket->user->name,
            'email' => $ticket->user->email,
            'ci' => $ticket->user->ci,
            'event' => $ticket->event->name,
            'date' => $ticket->event->event_date,
        ];
        return response()->json(['success' => 'Ticket confirmado correctamente', 'data' => $data]);
    }
}
