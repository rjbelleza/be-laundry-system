<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [ServiceController::class, 'index']);
Route::post('/', [OrderController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', function () {
        return \App\Models\User::paginate(10);
    });
});
