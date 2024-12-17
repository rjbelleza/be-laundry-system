<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\ForgotPasswordController; 
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-test-email', function () { 
    Mail::raw('This is a test email', function ($message) { 
        $message->to('john@example.com') 
                ->subject('Test Email'); 
            }); 

            return 'Test email sent!'; 
        });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email'); 
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
