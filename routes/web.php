<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/register-next-page', [AuthController::class, 'showRegisterNextPage'])->name('register-next-page');
    Route::post('/register-next-page', [AuthController::class, 'register-next-page']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/employer-login', [AuthController::class, 'showEmployerLogin'])->name('employer-login');
    Route::post('/employer-login', [AuthController::class, 'employer-login']);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
require __DIR__ . '/auth.php';
