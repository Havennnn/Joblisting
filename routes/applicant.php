<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SetupController;
use App\Http\Controllers\Applicant\MyApplicationsController;
use App\Http\Controllers\Applicant\NotificationController;

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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/picture/{user}', [ProfileController::class, 'showProfilePicture'])->name('profile.picture');
    Route::get('/profile/resume/{user}', [ProfileController::class, 'downloadResume'])->name('profile.resume');

    // Job application routes
    Route::post('/jobs/{job}/apply', [MyApplicationsController::class, 'store'])->name('apply.job');
    Route::get('/my-applications', [MyApplicationsController::class, 'index'])->name('applications');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');

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
