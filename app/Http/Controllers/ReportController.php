<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class ReportController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('pages.reports.index')->with('events', $events);
    }

    public function generateByEvent(Request $request)
    {
        $event = Event::where('id', $request->event_id)->first();
        $totalTickets = $event->tickets->count();
        $totalUsedTickets = $event->tickets->where('confirmed', 1)->count();
        $totalRevenue = $event->tickets->sum(function ($ticket) {
            return $ticket->ticketType->price;
        });
        $totalTicketsPerType = $event->tickets->groupBy('ticket_type_id')->mapWithKeys(function ($row, $key) {
            $ticketTypeName = $row->first()->ticketType->name; // Obtener el nombre del tipo de ticket
            return [$ticketTypeName => $row->count()];
        });
        
        $data = [
            'event' => $event,
            'totalTickets' => $totalTickets,
            'totalUsedTickets' => $totalUsedTickets,
            'totalRevenue' => $totalRevenue,
            'totalTicketsPerType' => $totalTicketsPerType
        ];

       return response()->json($data);
    }
}
