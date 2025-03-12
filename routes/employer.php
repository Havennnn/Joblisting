<?php


use App\Http\Controllers\Auth\EmployerAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        Route::get('login', [EmployerAuthController::class, 'loginForm'])
            ->name('login');

        Route::get('register', function () {
            return view('employerregister');
        })->name('register');

        // Employer Authentication Logic
        Route::post('login', [EmployerAuthController::class, 'login'])->name('login.post');
        Route::post('register', [EmployerAuthController::class, 'register'])->name('register.post');
        Route::post('logout', [EmployerAuthController::class, 'logout'])->name('logout');
    });

Route::middleware(['auth:employer'])->group(function () {
    Route::get('dashboard', function () {
        return view('employer-dashboard'); // Use the correct filename
    })->name('dashboard');
});
