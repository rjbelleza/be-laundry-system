<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
}
