<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\UserListController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/services', [ServiceController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', function () {
        return \App\Models\User::paginate(10);
    })->middleware('role:admin'); // Only admins can access the user list

    // Customer-specific routes
    Route::middleware('role:customer')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    });

    // Admin-specific routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/userlist', [UserListController::class, 'index'])->name('admin.userlist');
    });
});
