<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login function
    public function login(Request $request)
    {   
        $credentials = $request->only('email', 'password');
        Log::info('Login attempt', ['credentials' => $credentials]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            Log::info('User authenticated', ['user' => $user]);

            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        }

        Log::warning('Invalid login attempt', ['credentials' => $credentials]);
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Logout function
    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:users', 
            'password' => 'required|string|min:8', 
        ]); 
        
        if ($validator->fails()) { 
            return response()->json($validator->errors(), 400); 
        } 
        
        $user = User::create([ 
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
        ]); 
        
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201); }
}
