<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';


// Employer Routes
Route::get('/employer/login', function () {
    return view('employerlogin');
})->name('employer.login');

Route::get('/employer/register', function () {
    return view('employerregister');
})->name('employer.register');
