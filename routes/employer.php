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
use App\Http\Controllers\Employer\ApplicationController;
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

Route::prefix('employer')->name('employer.')->middleware(['auth', 'employer'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Setup wizard routes
    Route::controller(SetupController::class)->prefix('setup')->name('setup')->group(function () {
        Route::get('/', 'index');
        Route::post('/step-one', 'processStepOne')->name('.step-one');
        Route::post('/step-two', 'processStepTwo')->name('.step-two');
        Route::post('/step-three', 'processStepThree')->name('.step-three');
        Route::get('/previous', 'previous')->name('.previous');
        Route::get('/skip', 'skip')->name('.skip');
    });

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/logo/{user}', [ProfileController::class, 'showCompanyLogo'])->name('logo');
    });

    // Applicants routes
    Route::controller(ApplicationController::class)->prefix('applicants')->name('applicants')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->name('.view');
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

    //Application Management Routes
    Route::controller(ApplicationController::class)->prefix('applications')->name('applications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/job/{jobId}', 'showJobApplications')->name('job');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/status', 'updateStatus')->name('update-status');
        Route::get('/{id}/resume', 'downloadResume')->name('download-resume');
    });

    //Notification Routes
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::post('/read-all', 'markAllAsRead')->name('read-all');
        Route::delete('/{id}', 'delete')->name('delete');
    });
});
