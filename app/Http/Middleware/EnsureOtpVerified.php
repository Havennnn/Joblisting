<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to logout and OTP verification routes
        if ($request->is('logout*') ||
            $request->is('logout-during-otp') ||
            $request->is('otp-*') ||
            $request->routeIs('logout') ||
            $request->routeIs('otp.*')) {
            return $next($request);
        }

        // Check if user is logged in and requires OTP verification
        if (Auth::check() && session('requires_otp_verification')) {
            return redirect()->route('otp.verify.page', ['email' => Auth::user()->email])
                ->with('message', 'Please verify your email address before proceeding.');
        }

        return $next($request);
    }
}
