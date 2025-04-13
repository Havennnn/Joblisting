<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureOtpEligibility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and requires OTP verification
        if (Auth::check() && session('requires_otp_verification')) {
            return $next($request);
        }

        // Check if there's a valid OTP in session for the email being verified
        $email = $request->email ?? null;
        if ($email && session()->has('otp_' . $email)) {
            return $next($request);
        }

        // Check if there's an OTP generation timestamp for this email
        if ($email && session()->has('otp_generated_at_' . $email)) {
            return $next($request);
        }

        // Check if this is a valid post-registration flow
        if (session('registration_completed') && $email) {
            return $next($request);
        }

        // Redirect unauthorized access to content unavailable page
        return redirect()->route('content.unavailable', ['intended' => $request->path()]);
    }
}
