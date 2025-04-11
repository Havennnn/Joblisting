<?php

namespace App\Http\Controllers\Auth\Employer;

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
     * Show the employer login form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->isEmployer()) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('employer.login');
    }

    /**
     * Handle an employer login request
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

            // Check if user is an employer
            if (!$user->isEmployer()) {
                Auth::logout();
                return back()->withErrors(['email' => 'This account is not an employer account.']);
            }

            return redirect()->intended(route('employer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
