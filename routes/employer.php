<?php

use App\Http\Model\JobPost;
use App\Http\Controllers\Employer\JobListingController;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\Employer\SetupController;
use App\Http\Controllers\Employer\Notification\CentralNotificationController;
use App\Http\Controllers\Employer\ApplicationController;
use App\Http\Controllers\Employer\Company\CompanyController;
use App\Http\Controllers\Employer\InterviewController;
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
    Route::controller(SetupController::class)->prefix('setup')->name('setup.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'processSetup')->name('process');
        Route::get('/skip', 'skip')->name('skip');
    });

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'show')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
        Route::get('/logo/{user}', [ProfileController::class, 'showCompanyLogo'])->name('logo');
    });

    // Company management routes
    Route::prefix('company')->name('company.')->group(function () {
        // Main company page
        Route::get('/', [CompanyController::class, 'index'])->name('index');

        // Company creation
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/create', [CompanyController::class, 'store'])->name('store');

        // Company settings
        Route::get('/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::put('/update', [CompanyController::class, 'update'])->name('update');
        Route::delete('/delete', \App\Http\Controllers\Employer\Company\DeleteCompanyController::class)->name('delete');

        // Company member management
        Route::delete('/members/{id}', \App\Http\Controllers\Employer\Company\Member\KickMemberController::class)->name('kick-member');

        // Company job post management
        Route::get('/job-posts/{id}', \App\Http\Controllers\Employer\Company\JobPost\ViewJobPostController::class)->name('job-post.view');
        Route::get('/job-posts/{id}/edit', \App\Http\Controllers\Employer\Company\JobPost\EditJobPostController::class)->name('job-post.edit');
        Route::delete('/job-posts/{id}', \App\Http\Controllers\Employer\Company\JobPost\DeleteJobPostController::class)->name('job-post.delete');

        // Company invites - individual routes to avoid parameter issues
        Route::get('/invite', \App\Http\Controllers\Employer\Company\Invite\ShowInviteFormController::class)->name('invite');
        Route::post('/invite', \App\Http\Controllers\Employer\Company\Invite\SendInviteController::class)->name('invite.send');
        Route::get('/invite/{token}', \App\Http\Controllers\Employer\Company\Invite\AcceptInviteController::class)->name('invite.accept');
        Route::get('/invite/{token}/decline', \App\Http\Controllers\Employer\Company\Invite\DeclineInviteController::class)->name('invite.decline');
        Route::delete('/invite/{id}', \App\Http\Controllers\Employer\Company\Invite\CancelInviteController::class)->name('invite.cancel');
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
        Route::get('/{id}/schedule', 'showScheduleForm')->name('schedule.form');
        Route::post('/{id}/schedule', 'scheduleInterview')->name('schedule');
    });

    //Notification Routes
    Route::controller(CentralNotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::post('/read-all', 'markAllAsRead')->name('read-all');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    // Interview Scheduling Routes
    Route::controller(InterviewController::class)->prefix('interviews')->name('interviews.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
