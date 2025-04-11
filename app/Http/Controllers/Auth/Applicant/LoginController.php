<?php

namespace App\Http\Controllers\Auth\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /**
     * Show the applicant login form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isApplicant()) {
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.login');
    }

    /**
     * Handle an applicant login request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check if user's email is verified
            if (!$user->email_verified_at) {
                // For unverified users, generate OTP and redirect to verification
                try {
                    // Get the user's email
                    $email = $user->email;

                    // Generate OTP
                    $otp = rand(100000, 999999);

                    // Store OTP in session
                    session([
                        'otp_' . $email => $otp,
                        'otp_expires_at_' . $email => now()->addMinutes(10),
                        'requires_otp_verification' => true
                    ]);

                    // Create verification link
                    $verificationLink = route('otp.verify.page', ['email' => $email]);

                    // Send OTP email
                    Mail::to($email)->send(new OtpMail($email, $otp, $verificationLink));

                    return redirect()->route('otp.verify.page', ['email' => $email])
                        ->with('message', 'Please verify your email address to continue.');
                } catch (\Exception $e) {
                    // Log the user out as a fallback
                    Auth::logout();
                    return back()->withErrors(['email' => 'Error sending verification email. Please try again.']);
                }
            }

            // For verified users, proceed with normal login
            $request->session()->regenerate();

            // Check if user is an applicant
            if (!$user->isApplicant()) {
                Auth::logout();
                return back()->withErrors(['email' => 'This account is not an applicant account.']);
            }

            return redirect()->intended(route('applicant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
