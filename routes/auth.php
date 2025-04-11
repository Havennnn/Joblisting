<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OtpAuthController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| This file contains all authentication-related routes including:
| - Login/logout for both applicants and employers
| - Registration routes for applicants and employers
| - Password reset and email verification routes
|
*/

// General register route for backward compatibility
Route::get('/register', function() {
    // Check if type=employer is in the query string, otherwise default to applicant
    return request()->has('type') && request()->type === 'employer'
        ? redirect()->route('employer.register')
        : redirect()->route('applicant.register');
})->name('register')->middleware('guest');

// General login route for backward compatibility
Route::get('/login', function() {
    // Check if type=employer is in the query string, otherwise default to applicant
    return request()->has('type') && request()->type === 'employer'
        ? redirect()->route('employer.login')
        : redirect()->route('applicant.login');
})->name('login')->middleware('guest');

// Register multi-step routes
Route::get('/register-next-page', [AuthController::class, 'showRegisterNextPage'])
    ->name('register-next-page')
    ->middleware('guest');

// Applicant authentication routes (guest only)
Route::prefix('applicant')->name('applicant.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showApplicantLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'loginApplicant'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showApplicantRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerApplicant'])->name('register.post');
});

// Employer authentication routes (guest only)
Route::prefix('employer')->name('employer.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showEmployerLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'loginEmployer'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showEmployerRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerEmployer'])->name('register.post');
});

// OTP verification routes
Route::middleware('guest')->group(function () {
    // OTP Login
    Route::get('/otp-login', [OtpAuthController::class, 'showLoginForm'])->name('otp.login');
    Route::post('/otp-login', [OtpAuthController::class, 'login'])->name('otp.login.post');

    // OTP Registration
    Route::get('/otp-register', [OtpAuthController::class, 'showRegisterForm'])->name('otp.register');
    Route::post('/otp-register', [OtpAuthController::class, 'register'])->name('otp.register.post');

    // SMS OTP - API endpoint
    Route::post('/otp-sms', [OtpAuthController::class, 'sendOtpSms'])->name('otp.sms');
});

// OTP verification routes - accessible to both guests and auth users who need verification
Route::middleware('web')->withoutMiddleware([\App\Http\Middleware\EnsureOtpVerified::class])->group(function () {
    // OTP Verification
    Route::get('/otp-verify', [OtpAuthController::class, 'showOtpVerificationPage'])->name('otp.verify.page');
    Route::post('/otp-verify', [OtpAuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp-resend', [OtpAuthController::class, 'resendOtp'])->name('otp.resend');

    // Make logout accessible during OTP verification
    Route::post('/logout-during-otp', [AuthController::class, 'logout'])->name('logout');
});

// Shared logout route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Employer-specific logout route
    Route::post('/employer/logout', [AuthController::class, 'logout'])->name('employer.logout');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');

    // Social Authentication Routes
    Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');

    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Email verification routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])
      ->name('verification.send');
});
