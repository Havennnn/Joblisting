<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmployerAuthController;
use Livewire\Volt\Volt;

// Redirect root to login
Route::redirect('/', '/login');

// Guest routes (login & registration)
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Applicant registration
    Route::get('/applicant/register', [AuthController::class, 'showApplicantRegister'])->name('applicant.register');
    Route::post('/applicant/register', [AuthController::class, 'registerApplicant']);

    // Employer registration
    Route::get('/employer/register', [AuthController::class, 'showEmployerRegister'])->name('employer.register');
    Route::post('/employer/register', [AuthController::class, 'registerEmployer']);

    // Password reset routes
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Applicant routes
Route::prefix('applicant')->name('applicant.')->middleware(['auth', 'applicant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Employer routes
Route::prefix('employer')->name('employer.')->middleware(['auth', 'employer'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'employerDashboard'])->name('dashboard');
});

// Email verification routes
Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Volt::route('confirm-password', 'pages.auth.confirm-password')->name('password.confirm');
});

// Shared profile route
Route::view('profile', 'shared.profile')
    ->middleware(['auth'])
    ->name('profile');

// Include other route files
require __DIR__ . '/auth.php';
require __DIR__ . '/applicant.php';
require __DIR__ . '/employer.php';
