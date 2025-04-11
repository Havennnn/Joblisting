<?php

use App\Http\Model\JobPost;
use App\Http\Controllers\Employer\JobListingController;
use App\Http\Controllers\Employer\JobListing\CreateController;
use App\Http\Controllers\Employer\JobListing\StoreController;
use App\Http\Controllers\Employer\JobListing\ShowController;
use App\Http\Controllers\Employer\JobListing\EditController;
use App\Http\Controllers\Employer\JobListing\UpdateController;
use App\Http\Controllers\Employer\JobListing\DestroyController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\Employer\SetupController;
use App\Http\Controllers\Employer\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::post('/setup/step-one', [SetupController::class, 'processStepOne'])->name('setup.step-one');
    Route::post('/setup/step-two', [SetupController::class, 'processStepTwo'])->name('setup.step-two');
    Route::post('/setup/step-three', [SetupController::class, 'processStepThree'])->name('setup.step-three');
    Route::get('/setup/previous', [SetupController::class, 'previous'])->name('setup.previous');
    Route::get('/setup/skip', [SetupController::class, 'skip'])->name('setup.skip');

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/logo/{user}', [ProfileController::class, 'showCompanyLogo'])->name('logo');
    });

    // Job Post routes - UPDATED to use JobListingController as a facade
    Route::controller(JobListingController::class)->prefix('job-posts')->name('JobPost')->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create')->name('.create');
        Route::post('/', 'store')->name('.store');
        Route::get('/{id}', 'show')->name('.show');
        Route::get('/{id}/edit', 'edit')->name('.edit');
        Route::put('/{id}', 'update')->name('.update');
        Route::delete('/{id}', 'destroy')->name('.destroy');
    });

    /**
     * Application Management Routes
     */
    Route::controller(ApplicationController::class)->prefix('applications')->name('applications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/job/{jobId}', 'showJobApplications')->name('job');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/status', 'updateStatus')->name('update-status');
        Route::get('/{id}/resume', 'downloadResume')->name('download-resume');
    });

    /**
     * Notification Routes
     */
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::post('/read-all', 'markAllAsRead')->name('read-all');
        Route::delete('/{id}', 'delete')->name('delete');
    });

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
