<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShowVerificationController extends Controller
{
    /**
     * Show OTP verification page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Get email from request or from authenticated user
        $email = $request->email ?? (Auth::check() ? Auth::user()->email : null);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Unable to verify email. Please try logging in again.');
        }

        // Check for valid verification context
        $validContext = false;

        // Context 1: User is logged in and requires OTP verification
        if (Auth::check() && session('requires_otp_verification')) {
            $validContext = true;
            Log::info('OTP verification for logged in user', ['user_id' => Auth::id()]);
        }

        // Context 2: There's a valid OTP in session for this email
        elseif (session()->has('otp_' . $email)) {
            $validContext = true;
            Log::info('OTP verification with valid OTP in session', ['email' => $email]);
        }

        // Context 3: There's an OTP generation timestamp for this email
        elseif (session()->has('otp_generated_at_' . $email)) {
            $validContext = true;
            Log::info('OTP verification with generation timestamp', ['email' => $email]);
        }

        // Context 4: This is post-registration
        elseif (session('registration_completed')) {
            $validContext = true;
            Log::info('OTP verification after registration', ['email' => $email]);
        }

        // If not a valid context, redirect to login
        if (!$validContext) {
            Log::warning('Unauthorized attempt to access OTP verification', ['email' => $email, 'ip' => $request->ip()]);
            return redirect()->route('login')
                ->with('error', 'Unauthorized access. Please log in first.');
        }

        return view('auth.otp.otp-verify', ['email' => $email]);
    }
}
