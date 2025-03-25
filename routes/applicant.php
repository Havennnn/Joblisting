<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;

// All applicant routes are prefixed with 'applicant' and named with 'applicant.'
Route::middleware(['auth', 'applicant'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Job Search routes (commented out for future implementation)
    // Route::get('/job-search', [JobSearchController::class, 'index'])->name('job-search');

    // Job application routes (commented out for future implementation)
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
});
