<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\FindJobController;
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

// Public job routes
Route::prefix('jobs')->group(function () {
    // Job listings and search
    Route::get('/', [FindJobController::class, 'index'])->name('jobs.index');
    Route::get('/search', [FindJobController::class, 'search'])->name('jobs.search');
    Route::get('/{id}', [FindJobController::class, 'show'])->name('jobs.show');

    // Landing page specific job routes
    Route::prefix('landing')->group(function () {
        Route::get('/', [LandingPageController::class, 'jobs'])->name('landing.jobs');
        Route::get('/job-details/{id}', [LandingPageController::class, 'jobDetails'])->name('landing.job.details');
    });
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
