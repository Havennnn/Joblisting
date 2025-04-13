<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsApplicant;
use App\Http\Middleware\EnsureUserIsEmployer;
use App\Http\Middleware\SetUserLayout;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\EnsureOtpVerified;
use App\Http\Middleware\EnsureOtpEligibility;
use App\Http\Middleware\EnsureAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        then: function() {
            Route::middleware('web')
                ->group(base_path('routes/employer.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add SetUserLayout to the web middleware group
        $middleware->web(append: [
            SetUserLayout::class,
            EnsureOtpVerified::class,
        ]);

        // Register middleware aliases
        $middleware->alias([
            'applicant' => EnsureUserIsApplicant::class,
            'employer' => EnsureUserIsEmployer::class,
            'set.layout' => SetUserLayout::class,
            'guest' => RedirectIfAuthenticated::class,
            'otp.verified' => EnsureOtpVerified::class,
            'ensure.otp.eligibility' => EnsureOtpEligibility::class,
            'auth.custom' => EnsureAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
