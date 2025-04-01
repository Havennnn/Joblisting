<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPage\LandingController;
use App\Http\Controllers\LandingPage\JobController;

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
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/job-details/{id}', [JobController::class, 'show'])->name('jobs.show');

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
