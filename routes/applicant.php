<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SetupController;

// All applicant routes are prefixed with 'applicant' and named with 'applicant.' - Marab
Route::prefix('applicant')->name('applicant.')->middleware(['auth', 'applicant'])->group(function () {

    // Setup wizard routes (Complete)
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');
    Route::get('/setup/skip', [SetupController::class, 'skip'])->name('setup.skip');

    // Dashboard (Incomplete)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (Futher Improvement)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Job Search routes (Franklin)
    // Route::get('/job-search', [JobSearchController::class, 'index'])->name('job-search');

    // Job recommendation routes (Franklin)
    // Route::get('/job-recommendations', [JobRecommendationController::class, 'index'])->name('job-recommendations');

    // Interview preparation routes (Franklin)
    // Route::get('/interview-preparation', [InterviewPreparationController::class, 'index'])->name('interview-preparation');

    // Chat routes (Marab)
    // Route::get('/chat', [ChatController::class, 'index'])->name('chat');

    // Job application routes (Marab)
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');

    // Applied jobs routes (Marab)
    // Route::get('/applied-jobs', [AppliedJobController::class, 'index'])->name('applied-jobs');

    // Saved jobs routes (Franklin)
    // Route::get('/saved-jobs', [SavedJobController::class, 'index'])->name('saved-jobs');

    Route::get('/jobs', [JobController::class, 'index']); 
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/interview', [InterviewController::class, 'index']); 
    Route::get('/profile', [ProfileController::class, 'index']);

});
