<?php

use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\Employer\SetupController;
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

    // Setup wizard routes
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::post('/setup/step-one', [SetupController::class, 'processStepOne'])->name('setup.step-one');
    Route::post('/setup/step-two', [SetupController::class, 'processStepTwo'])->name('setup.step-two');
    Route::post('/setup/step-three', [SetupController::class, 'processStepThree'])->name('setup.step-three');
    Route::get('/setup/previous', [SetupController::class, 'previous'])->name('setup.previous');
    Route::get('/setup/skip', [SetupController::class, 'skip'])->name('setup.skip');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

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
