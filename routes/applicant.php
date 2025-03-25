<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\DashboardController;
use App\Http\Controllers\Applicant\ProfileController;

// All routes here are prefixed with 'applicant' and named with 'applicant.'

Route::middleware(['auth', 'applicant'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Job application routes (SOON)
    // Route::get('/applications', [ApplicationController::class, 'index'])->name('applications');
    // ...
});
