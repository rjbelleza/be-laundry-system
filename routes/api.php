<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();  
    });

    // Admin-specific routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function () {
            return \App\Models\User::all();
        });

        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);    
        Route::delete('/users/{id}', [UserController::class, 'destroy']); 
    });

    // Customer-specific routes
    Route::middleware('role:customer')->group(function () {
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']); 
        Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    });
});
