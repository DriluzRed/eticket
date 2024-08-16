<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Department;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function index()
    {

        $events = Event::all();
        return view('pages.events.index')->with('events', $events);

    }

  
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'event_date' => 'required|date',
                'city_id' => 'required|exists:cities,id',
                'address' => 'required|string',
                'capacity' => 'nullable|integer',
            ]);

    
            $event = Event::create($validated);
            return redirect()->route('events.index')->with('success', 'Evento creado exitosamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function create()
    {
        $departments = Department::all();
        $cities = City::all();
        return view('pages.events.create')
            ->with('cities', $departments)
            ->with('cities', $cities);
    }

    public function show($id)
    {
 
            $event = Event::findOrFail($id);
            return view('pages.events.show')->with('event', $event);
   
    }

    public function edit($id){
        $cities = City::all();
        $event = Event::findOrFail($id);
        return view('pages.events.edit')
            ->with('event', $event)
            ->with('cities', $cities);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'event_date' => 'required|date',
                'city_id' => 'required|exists:cities,id',
                'address' => 'required|string',
                'capacity' => 'nullable|integer',
            ]);

            $event = Event::findOrFail($id);
            $event->update($validated);
            return redirect()->route('events.index')->with('success', 'Evento actualizado exitosamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
           return view ('errors.404');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }


   public function destroy($id){
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            return redirect()->route('events.index')->with('success', 'Evento eliminado exitosamente.');
        } catch (ModelNotFoundException $e) {
            return view ('errors.404');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
   }
}
