<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.users.index')->with('users', $users);
    }

    public function create()
    {
        return redirect()->route('users.index')->with('error', 'NO PUEDES CREAR USUARIOS ACTUALMENTE');
    }

    public function store(Request $request)
    {
        return redirect()->route('users.index')->with('error', 'NO PUEDES CREAR USUARIOS ACTUALMENTE');
    }
    
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('user.not_found')], 404);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.users.edit')->with('user', $user);   
    }


    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ci' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail($id);
        $user->ci = $validated['ci'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
        
    }
    
    public function destroy($id)
    {

    }
}
