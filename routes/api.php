<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProductController;

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
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    Route::get('/products', [ProductController::class, 'index']);

    // Admin-specific routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function () {
            return \App\Models\User::all();
        });
        Route::put('/users/{id}/role', [UserController::class, 'updateRole']);    
        Route::delete('/users/{id}', [UserController::class, 'destroy']); 
        Route::put('/services/{id}', [ServiceController::class, 'update']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
        Route::get('/fetchOrders', [OrderController::class, 'showAll']);
        Route::put('/updateOrders/{id}/status', [OrderController::class, 'updateStatus']);
    });

    // Customer-specific routes
    Route::middleware('role:customer')->group(function () {
        Route::post('/orders', [OrderController::class, 'store']); 
        Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel']);
        Route::get('/orders', [OrderController::class, 'index']);
    });
});
