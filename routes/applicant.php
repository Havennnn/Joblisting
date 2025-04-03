<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SetupController;

/*
|--------------------------------------------------------------------------
| Applicant Routes (Protected)
|--------------------------------------------------------------------------
|
| All routes in this file are for authenticated applicants only.
| All routes are prefixed with 'applicant' and have the name prefix 'applicant.'
|
*/

Route::prefix('applicant')->name('applicant.')->middleware(['auth', 'applicant'])->group(function () {
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
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
     * Future routes to implement:
     */

    // Job Search routes
    // Route::get('/job-search', [JobSearchController::class, 'index'])->name('job-search');

    // Job recommendations
    // Route::get('/job-recommendations', [JobRecommendationController::class, 'index'])->name('job-recommendations');

    // Interview preparation
    // Route::get('/interview-preparation', [InterviewPreparationController::class, 'index'])->name('interview-preparation');

    // Application management
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
    // Route::get('/applied-jobs', [AppliedJobController::class, 'index'])->name('applied-jobs');
    // Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs');
});
