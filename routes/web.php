<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPage\LandingController;
use App\Http\Controllers\LandingPage\JobController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Settings\SettingsController as SettingsSettingsController;

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
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Public job listing routes
Route::get('/jobs', [PublicJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [PublicJobController::class, 'search'])->name('jobs.search');
Route::get('/job-details/{id}', [PublicJobController::class, 'show'])->name('jobs.show');

// Route for settings (accessible by both applicants and employers)
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsSettingsController::class, 'index'])->name('settings.index');

    // Email change with OTP verification
    Route::get('/settings/email/change', [SettingsSettingsController::class, 'showEmailChangeForm'])
        ->name('settings.email.change.form');
    Route::post('/settings/email/change', [SettingsSettingsController::class, 'initiateEmailChange'])
        ->name('settings.email.change');
    Route::get('/settings/email/verify', [SettingsSettingsController::class, 'showEmailChangeVerification'])
        ->name('settings.email.verify');
    Route::post('/settings/email/verify', [SettingsSettingsController::class, 'verifyEmailChange'])
        ->name('settings.email.verify.submit');
});

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
