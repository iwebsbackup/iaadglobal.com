<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegistrationPaymentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/committee', 'committee')->name('committee');
Route::view('/venue', 'venue')->name('venue');
Route::view('/contact', 'contact')->name('contact');
Route::view('/registration', 'registration')->name('registration');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');

    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email')->middleware('throttle:5,1');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/registration-payment', [RegistrationPaymentController::class, 'show']);
    Route::post('/registration-payment', [RegistrationPaymentController::class, 'store']);
});

Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');

Route::post('/logout', LogoutController::class)->middleware('auth');
