<?php

use App\Http\Controllers\Auth\EmployerAuthController;
use Illuminate\Support\Facades\Route;

// Employer authentication routes
Route::middleware('guest')
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        // Login routes
        Route::get('login', [EmployerAuthController::class, 'loginForm'])->name('login');
        Route::post('login', [EmployerAuthController::class, 'login'])->name('login.post');

        // Registration routes
        Route::get('register', function () {
            return view('employerregister');
        })->name('register');
        Route::post('register', [EmployerAuthController::class, 'register'])->name('register.post');

        // Logout route
        Route::post('logout', [EmployerAuthController::class, 'logout'])->name('logout');
    });

// Protected employer routes
Route::middleware(['auth:employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('dashboard', function () {
            return view('employer-dashboard');
        })->name('dashboard');
    });
