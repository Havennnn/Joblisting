<?php

use App\Http\Controllers\Auth\EmployerAuthController;
use App\Http\Controllers\Employer\DashboardController;
use Illuminate\Support\Facades\Route;


// This file is for additional employer-specific routes
Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    // Add other employer-specific routes here
    // Example:
    // Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
});
