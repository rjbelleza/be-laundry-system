<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Use the paginate method to paginate users, with a default of 10 users per page
        $users = User::paginate(10);

        // Return the paginated response
        return response()->json($users);

    }

    public function updateRole(Request $request, $id)
    {
            $user = User::find($id); 
            
            if (!$user) { 
                return response()->json(['message' => 'User not found'], 404); 
            } 
            
            $user->role = $request->input('role'); 
            $user->save(); 
            
            return response()->json(['message' => 'User role updated successfully', 'user' => $user], 200); 
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
