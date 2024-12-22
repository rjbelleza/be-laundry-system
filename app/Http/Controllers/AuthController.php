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
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Login attempt', ['email' => $credentials['email']]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('User authenticated', ['user_id' => $user->id]);

            // Role-based redirection
            $role = $user->role;
            $roleMap = [
                'admin' => 'admin',
                'customer' => 'customer',
                'courier' => 'courier'
            ];

            return response()->json([
                'message' => 'Login successful',
                'role' => $roleMap[$role] ?? 'unknown',
                'token' => $token
            ], 200);
        }

        Log::warning('Invalid login attempt', ['email' => $credentials['email']]);
        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    // Logout function
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);    
    }

    // Register function
    public function register(Request $request)
    {
        Log::info('Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'postal_code' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            Log::error('Registration validation failed', ['errors' => $validator->errors()]);
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'mobile' => $request->mobile,
                'postal_code' => $request->postal_code,
            ]);

            // Create a token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'User created successfully', 'user' => $user, 'token' => $token], 201);
        } catch (\Exception $e) {
            Log::error('Error occurred during user registration', ['exception' => $e]);
            return response()->json(['message' => 'Error occurred during user registration'], 500);
        }
    }
}
