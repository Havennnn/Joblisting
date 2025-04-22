<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\OtpAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| This file contains all authentication-related routes including:
| - Login/logout for both applicants and employers
| - Registration routes for applicants and employers
| - Password reset routes
| - Routes for authenticated users to manage their account settings
|
*/

// Applicant authentication routes
Route::prefix('applicant')->name('applicant.')->middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showApplicantLogin')->name('login');
        Route::post('/login', 'loginApplicant')->name('login.post');
        Route::get('/register', 'showApplicantRegister')->name('register');
        Route::post('/register', 'registerApplicant')->name('register.post');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showApplicantForm')->name('password.request');
        Route::post('/forgot-password', 'sendApplicantResetLink')->name('password.email');
    });
});

// Employer authentication routes
Route::prefix('employer')->name('employer.')->middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showEmployerLogin')->name('login');
        Route::post('/login', 'loginEmployer')->name('login.post');
        Route::get('/register', 'showEmployerRegister')->name('register');
        Route::post('/register', 'registerEmployer')->name('register.post');
    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showEmployerForm')->name('password.request');
        Route::post('/forgot-password', 'sendEmployerResetLink')->name('password.email');
    });
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/reset-password', 'showResetForm')->name('password.reset.otp');
        Route::post('/reset-password', 'resetPassword')->name('password.update.otp');
    });
});

// OTP authentication routes
Route::middleware('guest')->group(function () {
    Route::controller(OtpAuthController::class)->group(function () {
        // Login and registration
        Route::get('/otp-login', 'showLoginForm')->name('otp.login');
        Route::post('/otp-login', 'login')->name('otp.login.post');
        Route::get('/otp-register', 'showRegisterForm')->name('otp.register');
        Route::post('/otp-register', 'register')->name('otp.register.post');
    });
});

// OTP verification routes
Route::middleware(['web', 'ensure.otp.eligibility'])->withoutMiddleware([\App\Http\Middleware\EnsureOtpVerified::class])->group(function () {
    Route::controller(OtpAuthController::class)->group(function () {
        Route::get('/otp-verify', 'showOtpVerificationPage')->name('otp.verify.page');
        Route::post('/otp-verify', 'verifyOtp')->name('otp.verify');
        Route::post('/otp-resend', 'resendOtp')->name('otp.resend');
    });

        // Logout during OTP verification
    Route::post('/logout-during-otp', [AuthController::class, 'logout'])->name('logout');
});

// Social authentication routes
Route::middleware('guest')->group(function () {
    Route::controller(FacebookController::class)->group(function () {
        Route::get('auth/facebook', 'redirectToFacebook')->name('facebook.login');
        Route::get('auth/facebook/callback', 'handleFacebookCallback')->name('facebook.callback');
    });

    Route::controller(GoogleController::class)->group(function () {
        Route::get('auth/google', 'redirectToGoogle')->name('google.login');
        Route::get('auth/google/callback', 'handleGoogleCallback')->name('google.callback');
    });
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User settings routes - using Livewire for all settings functionality
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Keep these routes for backward compatibility and future expansion
    Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
        // Email settings (now handled by Livewire)
        Route::prefix('email')->name('email.')->group(function () {
            Route::get('/change', 'index')->name('change.form');
            Route::post('/change', 'index')->name('change');
            Route::get('/verify', 'index')->name('verify');
            Route::post('/verify', 'index')->name('verify.submit');
        });

        // Password settings (now handled by Livewire)
        Route::prefix('password')->name('password.')->group(function () {
            Route::get('/change', 'index')->name('change.form');
            Route::post('/change', 'index')->name('change.submit');
        });
    });
});
