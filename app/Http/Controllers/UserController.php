<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            if(!$users){
                return response()->json(['message'=> trans('user.not_found')], 404);
            }
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message'=>trans('user.error')], 500);
        }
    }

   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'address' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);
    
        $validated['password'] = bcrypt($validated['password']);
    
        try {
            $user = User::create($validated);
            return response()->json([
                'message' => trans('user.created'),
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('user.error')], 500);
        }
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

    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->update($validated);

            return response()->json([
                'message' => trans('user.updated'),
                'user' => $user
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('user.not_found')], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('user.error')], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if (!$user->delete()) {
                return response()->json(['message' => trans('user.error')], 500);
            }
            return response()->json(['message' => trans('user.deleted')]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => trans('user.not_found')], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('user.error')], 500);
        }
    }
}
