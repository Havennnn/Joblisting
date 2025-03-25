<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;

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
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Applicant routes
Route::prefix('applicant')->name('applicant.')->group(function () {
    // Applicant protected routes
    Route::middleware(['auth', 'applicant'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});

// Employer routes
Route::prefix('employer')->name('employer.')->group(function () {
    Route::middleware(['auth', 'employer'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'employerDashboard'])->name('dashboard');
    });
});

// Shared profile route
Route::view('profile', 'shared.profile')
    ->middleware(['auth'])
    ->name('profile');

// Other routes
require __DIR__ . '/auth.php';
