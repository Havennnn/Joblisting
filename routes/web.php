<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LandingPage\JobController;
use App\Http\Controllers\FindJobController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
|
| These routes are accessible to all users without authentication.
| This includes the landing page, job listings, and other public content.
|
*/

// Landing page routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Job routes delegated to the LandingPageController
Route::get('/landing/jobs', [LandingPageController::class, 'jobs'])->name('landing.jobs');
Route::get('/landing/job-details/{id}', [LandingPageController::class, 'jobDetails'])->name('landing.job.details');

// Public job finding routes
Route::get('/jobs', [FindJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [FindJobController::class, 'search'])->name('jobs.search');
Route::get('/job-details/{id}', [FindJobController::class, 'show'])->name('jobs.show');

// Route for settings (accessible by both applicants and employers)
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Email change with OTP verification
    Route::get('/settings/email/change', [SettingsController::class, 'showEmailChangeForm'])
        ->name('settings.email.change.form');
    Route::post('/settings/email/change', [SettingsController::class, 'initiateEmailChange'])
        ->name('settings.email.change');
    Route::get('/settings/email/verify', [SettingsController::class, 'showEmailChangeVerification'])
        ->name('settings.email.verify');
    Route::post('/settings/email/verify', [SettingsController::class, 'verifyEmailChange'])
        ->name('settings.email.verify.submit');

    // Password change routes
    Route::get('/settings/password/change', [SettingsController::class, 'showPasswordChangeForm'])
        ->name('settings.password.change.form');
    Route::post('/settings/password/change', [SettingsController::class, 'updatePassword'])
        ->name('settings.password.change');
});

// Content unavailable page route
Route::get('/content-unavailable', function(Request $request) {
    if ($request->has('intended')) {
        session(['url.intended' => $request->intended]);
    }
    return view('errors.content-unavailable');
})->name('content.unavailable');

/*
|--------------------------------------------------------------------------
| Route File Includes
|--------------------------------------------------------------------------
|
| Each file contains a specific set of routes:
| - auth.php: Authentication-related routes for login, registration
| - applicant.php: Protected routes for authenticated applicants
| - employer.php: Protected routes for authenticated employers
|
*/

require __DIR__ . '/auth.php';
require __DIR__ . '/applicant.php';
require __DIR__ . '/employer.php';
