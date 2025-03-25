<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Guest authentication routes
Route::middleware('guest')->group(function () {
    // Commented out to use our custom register routes
    // Volt::route('register', 'pages.auth.register')
    //     ->name('register');

    // Commented out to use our custom login route
    // Volt::route('login', 'pages.auth.login')
    //     ->name('login');

    // Password reset routes
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Email verification routes
    Volt::route('verify-email', 'pages.auth.verify-email')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Password confirmation route
    Volt::route('confirm-password', 'pages.auth.confirm-password')->name('password.confirm');
});
