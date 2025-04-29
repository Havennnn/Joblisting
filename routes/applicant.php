<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SetupController;
use App\Http\Controllers\Applicant\MyApplicationsController;
use App\Http\Controllers\Applicant\NotificationController;
use App\Http\Controllers\Applicant\SavedJobController;
use App\Http\Controllers\Applicant\InterviewResponseController;

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
    Route::controller(SetupController::class)->prefix('setup')->name('setup')->group(function () {
        Route::get('/', 'index');
        Route::post('/step-one', 'processStepOne')->name('.step-one');
        Route::post('/step-two', 'processStepTwo')->name('.step-two');
        Route::post('/step-three', 'processStepThree')->name('.step-three');
        Route::get('/previous', 'previous')->name('.previous');
        Route::get('/skip', 'skip')->name('.skip');
    });

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile')->group(function () {
        Route::get('/', 'show');
        Route::get('/edit', 'edit')->name('.edit');
        Route::put('/', 'update')->name('.update');
        Route::get('/picture/{user}', 'showProfilePicture')->name('.picture');
        Route::get('/resume/{user}', 'downloadResume')->name('.resume');
    });

    // Job application routes
    Route::controller(MyApplicationsController::class)->group(function () {
        Route::post('/jobs/{job}/apply', 'store')->name('apply.job');
        Route::get('/my-applications', 'index')->name('applications');
    });

    // Interview response routes
    Route::controller(InterviewResponseController::class)->prefix('interviews')->name('interviews.')->group(function () {
        Route::post('/{interviewId}/accept', 'accept')->name('accept');
        Route::post('/{interviewId}/decline', 'decline')->name('decline');
    });

    // Notification routes
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications')->group(function () {
        Route::get('/', 'index');
        Route::post('/{id}/read', 'markAsRead')->name('.read');
        Route::post('/read-all', 'markAllAsRead')->name('.read-all');
        Route::delete('/{id}', 'delete')->name('.delete');
    });

    // Saved Jobs routes
    Route::controller(SavedJobController::class)->prefix('saved-jobs')->name('saved-jobs')->group(function () {
        Route::get('/', 'index');
        Route::post('/{jobId}/save', 'save')->name('.save');
        Route::post('/{jobId}/unsave', 'unsave')->name('.unsave');
        Route::get('/{jobId}/check', 'isSaved')->name('.check');
    });
});
