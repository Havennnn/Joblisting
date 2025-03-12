<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployerAuthController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

// Employer Routes
Route::get('/employer/login', function () {
    return view('employerlogin');
})->name('employer.login');

Route::get('/employer/register', function () {
    return view('employerregister');
})->name('employer.register');

// Employer Authentication Logic
Route::post('/employer/login', [EmployerAuthController::class, 'login'])->name('employer.login.post');
Route::post('/employer/register', [EmployerAuthController::class, 'register'])->name('employer.register.post');
Route::post('/employer/logout', [EmployerAuthController::class, 'logout'])->name('employer.logout');

Route::middleware(['auth:employer'])->group(function () {
    Route::get('/employer/dashboard', function () {
        return view('employer-dashboard'); // Use the correct filename
    })->name('employer.dashboard');
});
