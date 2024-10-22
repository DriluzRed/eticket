<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use App\Mail\TicketRegistrationMail;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
class TicketController extends Controller
{

    public function index()
    {
        $tickets = Ticket::all();
        return view('pages.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $events = Event::all();
        $ticketTypes = TicketType::all();
        return view('pages.tickets.create')->with('events', $events)->with('ticketTypes', $ticketTypes);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
           

            $validated = $request->validate([
                'event_id' => 'required|exists:events,id',
                'ticket_type_id' => 'required|exists:ticket_types,id',
                'quantity' => 'required|integer|min:1|max:10',
                'email' => 'required|email',
                'name' => 'required|string',
                'ci' => 'required|string',
                'additional_tickets' => 'nullable|array',
                'additional_tickets.*.email' => 'nullable|email',
                'additional_tickets.*.name' => 'nullable|string',
                'additional_tickets.*.ci' => 'nullable|string',
            ]);

            

            $tickets = [];

            for ($i = 0; $i < $validated['quantity']; $i++) {
                $ticket = new Ticket();
                $ticket->event_id = $validated['event_id'];
                $ticket->ticket_type_id = $validated['ticket_type_id'];
                $ticket->qr_code = uniqid();
                
                $user = User::firstOrCreate(
                    ['email' => $validated['email']],
                    ['name' => $validated['name'], 'ci' => $validated['ci'], 'password' => Hash::make(Str::random(10))]
                );

                if ($i === 0) {
                    $ticket->user_id = $user->id;
                    
                } else {
                    $additionalUserData = $validated['additional_tickets'][$i] ?? null;

                    if ($additionalUserData) {
                        $additionalUser = User::firstOrCreate(
                            ['email' => $additionalUserData['email']],
                            ['name' => $additionalUserData['name'], 'ci' => $additionalUserData['ci'], 'password' => Hash::make(Str::random(10))]
                        );
                        $ticket->user_id = $additionalUser->id;
                    }
                }
    
                $ticket->save();
                $tickets[] = $ticket;

                $qrCodeUri = $this->generateQrCode($ticket);
                $this->generateQrCode($ticket);
                $background = public_path('img/bgticket.jpeg');
                $pdf = Pdf::loadView('tickets.template', [
                    'ticket' => $ticket,
                    'qrCodeUri' => $qrCodeUri,
                    'background' => $background
                ]);

                $pdfPath = 'public/tickets/' . $ticket->qr_code . '.pdf';

                Storage::put($pdfPath, $pdf->output());

            }

            DB::commit();

            foreach ($tickets as $ticket) {
                $pdfPath = 'public/tickets/' . $ticket->qr_code . '.pdf';
                Mail::to($ticket->user->email)->send(new TicketRegistrationMail($ticket, $pdfPath));
            }

            return redirect()->route('tickets.create')->with('success', 'Tickets registrados correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al registrar los tickets'. $e->getMessage())->withInput();
        }
    }

    protected function generateQrCode(Ticket $ticket)
    {
        $qrCode = new QrCode($ticket->qr_code);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filePath = 'public/qr_codes/' . $ticket->qr_code . '.png';
        Storage::put($filePath, $result->getString());

        $ticket->qr_path = $filePath;
        $ticket->save();

        return$result->getDataUri(); // Devuelve el Data URI para la vista
    }

    public function downloadQrCode($id)
    {
        $ticket = Ticket::findOrFail($id);
        return Storage::download($ticket->qr_path);
    }

    

    public function confirmTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->confirmed = true;
        $ticket->save();

        return back()->with('success', 'Ticket confirmado correctamente');
    }

    public function scanQrCode(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string'
        ]);

        $ticket = Ticket::where('qr_code', $validated['qr_code'])->first();

        if ($ticket) {
            $ticket->confirmed = true;
            $ticket->save();
            return response()->json(['message' => 'Ticket confirmado correctamente']);
        }

        return response()->json(['message' => 'Ticket no encontrado'], 404);
    }

    public function searchByCi(Request $request)
    {
        $ci = $request->input('ci');
        $user = User::where('ci', $ci)->first();

        if ($user) {
            return response()->json(['name' => $user->name, 'email' => $user->email]);
        } else {
            return response()->json([]);
        }
    }
}
