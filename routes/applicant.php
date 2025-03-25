<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SetupController;

// All applicant routes are prefixed with 'applicant' and named with 'applicant.'
Route::prefix('applicant')->name('applicant.')->middleware(['auth', 'applicant'])->group(function () {
    // Setup wizard routes
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');
    Route::get('/setup/skip', [SetupController::class, 'skip'])->name('setup.skip');

    // Dashboard (only accessible after setup or if setup is skipped)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Job Search routes (commented out for future implementation)
    // Route::get('/job-search', [JobSearchController::class, 'index'])->name('job-search');

    // Job application routes (commented out for future implementation)
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
});
