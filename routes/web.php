<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use Livewire\Volt\Volt;

// Redirect root to applicant login
Route::redirect('/', '/applicant/login');

//Landing page
Route::get('/', [LandingController::class, 'index']); 

// Applicant routes
Route::prefix('applicant')->name('applicant.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showApplicantLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'loginApplicant'])->name('login.post');

        // Applicant registration
        Route::get('/register', [AuthController::class, 'showApplicantRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'registerApplicant'])->name('register.post');
    });

    // Protected routes
    Route::middleware(['auth', 'applicant'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});

// Employer routes
Route::prefix('employer')->name('employer.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [EmployerAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [EmployerAuthController::class, 'login'])->name('login.post');
        Route::get('/register', [EmployerAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [EmployerAuthController::class, 'register'])->name('register.post');
    });

    // Protected routes
    Route::middleware(['auth', 'employer'])->group(function () {
        Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [EmployerAuthController::class, 'logout'])->name('logout');
    });
});

// Shared routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
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
