<?php

use App\Http\Model\JobPost;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\Employer\SetupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Employer\ApplicationController;

/*
|--------------------------------------------------------------------------
| Employer Routes (Protected)
|--------------------------------------------------------------------------
|
| All routes in this file are for authenticated employers only.
| All routes are prefixed with 'employer' and have the name prefix 'employer.'
|
*/

// Guest routes for Employer
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showEmployerLogin')->name('employer.login');
        Route::post('/login', 'loginEmployer');
        Route::get('/register', 'showEmployerRegister')->name('employer.register');
        Route::post('/register', 'registerEmployer');
    });
});

Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Setup wizard routes
    Route::middleware('employer.setup')->group(function () {
        Route::controller(SetupController::class)->prefix('setup')->name('setup')->group(function () {
            Route::get('/', 'index');
            Route::post('/step-1', 'processStepOne')->name('.step-1');
            Route::post('/step-2', 'processStepTwo')->name('.step-2');
            Route::post('/step-3', 'processStepThree')->name('.step-3');
            Route::post('/complete', 'complete')->name('.complete');
        });
    });

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/logo/{user}', [ProfileController::class, 'showCompanyLogo'])->name('logo');
    });

    // Job Post routes
    Route::controller(JobPostController::class)->prefix('JobPost')->group(function () {
        Route::get('', 'index')->name('JobPost');
        Route::get('create', 'create')->name('JobPost.create');
        Route::post('store', 'store')->name('JobPost.store');
        Route::get('{id}', 'show')->name('JobPost.show');
        Route::get('{id}/edit', 'edit')->name('JobPost.edit');
        Route::put('{id}', 'update')->name('JobPost.update');
        Route::delete('{id}', 'destroy')->name('JobPost.destroy');
    });

    // Application management
    Route::controller(ApplicationController::class)->prefix('applications')->name('applications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/status', 'updateStatus')->name('update-status');
    });

    /**
     * Job Posts Management Routes
     */
    Route::resource('job-posts', JobPostController::class);

    /**
     * Application Management Routes
     */
    Route::get('applications', [App\Http\Controllers\Employer\JobApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/job/{jobId}', [App\Http\Controllers\Employer\JobApplicationController::class, 'showJobApplications'])->name('applications.job');
    Route::get('applications/{id}', [App\Http\Controllers\Employer\JobApplicationController::class, 'show'])->name('applications.show');
    Route::put('applications/{id}/status', [App\Http\Controllers\Employer\JobApplicationController::class, 'updateStatus'])->name('applications.update-status');
    Route::get('applications/{id}/resume', [App\Http\Controllers\Employer\JobApplicationController::class, 'downloadResume'])->name('applications.download-resume');

    /*
     * Future routes to implement:
     */

    // Job management
    // Route::resource('/jobs', JobController::class);

    // Candidate search
    // Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates');
    // Route::get('/candidates/{id}', [CandidateController::class, 'show'])->name('candidates.show');

    // Company profile management
    // Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company-profile');
    // Route::put('/company-profile', [CompanyProfileController::class, 'update'])->name('company-profile.update');
});
