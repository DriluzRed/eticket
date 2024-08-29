<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketType;

class TicketTypeController extends Controller
{
    public function index(){
        $ticket_types = TicketType::all();
        return view('pages.ticket_types.index')->with('ticket_types', $ticket_types);
    }

    public function create(){
        return view('pages.ticket_types.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'is_courtesy' => 'required|boolean',
        ]);

        $ticketType = new TicketType();
        $ticketType->name = $request->name;
        $ticketType->description = $request->description;
        $ticketType->price = $request->price;
        $ticketType->is_courtesy = $request->is_courtesy;
        $ticketType->save();

        return redirect()->route('ticket_types.index')->with('success', 'Tipo de entrada creado correctamente');
    }

    public function edit($id){
        $ticketType = TicketType::find($id);
        return view('pages.ticket_types.edit')->with('ticket_type', $ticketType);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $ticketType = TicketType::find($id);
        $ticketType->name = $request->name;
        $ticketType->description = $request->description;
        $ticketType->price = $request->price;
        $ticketType->is_courtesy = $request->is_courtesy;
        if($ticketType->save()){
            return redirect()->route('ticket_types.index')->with('success', 'Tipo de entrada actualizado correctamente');
        }
        return back()->with('error', 'Ocurrió un error al actualizar el tipo de entrada')->withInput();
        
    }

    public function destroy($id){
        $ticketType = TicketType::find($id);
        if(!$ticketType->delete()){
            return back()->with('error', 'Ocurrió un error al eliminar el tipo de entrada');
        }
        return redirect()->route('ticket_types.index')->with('success', 'Tipo de entrada eliminado correctamente');
    }
}
