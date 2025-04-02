<?php

use App\Http\Controllers\Employer\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Employer Routes (Protected)
|--------------------------------------------------------------------------
|
| All routes in this file are for authenticated employers only.
| All routes are prefixed with 'employer' and have the name prefix 'employer.'
|
*/

Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile setup and edit routes
    Route::get('/setup', [DashboardController::class, 'setup'])->name('setup');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    /*
     * Future routes to implement:
     */

    // Job management
    // Route::resource('/jobs', JobController::class);

    // Application management
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
    // Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');

    // Candidate search
    // Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates');
    // Route::get('/candidates/{id}', [CandidateController::class, 'show'])->name('candidates.show');

    // Company profile management
    // Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company-profile');
    // Route::put('/company-profile', [CompanyProfileController::class, 'update'])->name('company-profile.update');
});
