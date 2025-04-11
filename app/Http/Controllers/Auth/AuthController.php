<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ApplicantProfile;
use App\Rules\AppropriateFullName;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Employer;

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * =========================================================================
     * Applicant Login Methods
     * =========================================================================
     */

    /**
     * Show the applicant login form
     */
    public function showApplicantLogin()
    {
        if (Auth::check() && Auth::user()->isApplicant()) {
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.login');
    }

    /**
     * Handle an applicant login request
     */
    public function loginApplicant(Request $request)
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

    /**
     * =========================================================================
     * Employer Login Methods
     * =========================================================================
     */

    /**
     * Show the employer login form
     */
    public function showEmployerLogin()
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
     */
    public function loginEmployer(Request $request)
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

    /**
     * =========================================================================
     * Applicant Registration Methods
     * =========================================================================
     */

    /**
     * Show the applicant registration form
     */
    public function showApplicantRegister()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->isEmployer()) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.register');
    }

    /**
     * Handle a registration request for a new applicant
     */
    public function registerApplicant(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,email_verified_at,NULL',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Check if user exists but is unverified
        $user = User::where('email', $validated['email'])->whereNull('email_verified_at')->first();

        if ($user) {
            // Update existing unverified user
            $user->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
            ]);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'applicant',
            ]);
        }

        // Set up the applicant profile if it doesn't exist
        $applicant = $user->applicantProfile ?? new ApplicantProfile();
        if (!$user->applicantProfile) {
            $applicant->user_id = $user->id;
            $applicant->full_name = $validated['name'];
            $applicant->setup_completed = false;
            $applicant->save();
            $user->refresh();
        }

        // Fire registered event
        event(new Registered($user));

        // Mark as pending setup
        session(['pending_setup' => 'applicant']);

        // Generate and send OTP
        try {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in session
            session([
                'otp_' . $user->email => $otp,
                'otp_expires_at_' . $user->email => now()->addMinutes(10),
                'requires_otp_verification' => true
            ]);

            // Create verification link
            $verificationLink = route('otp.verify.page', ['email' => $user->email]);

            // Send OTP email directly (no queue)
            Mail::to($user->email)->send(new OtpMail($user->email, $otp, $verificationLink));
        } catch (\Exception $e) {
            // Continue with redirection even if email fails
        }

        // Log the user in but mark as requiring OTP verification
        Auth::login($user);
        session(['requires_otp_verification' => true]);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify.page', ['email' => $user->email])
            ->with('message', 'Please verify your email to continue with setup.');
    }

    /**
     * =========================================================================
     * Employer Registration Methods
     * =========================================================================
     */

    /**
     * Show the employer registration form
     */
    public function showEmployerRegister()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->isEmployer()) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('employer.register');
    }

    /**
     * Handle a registration request for a new employer
     */
    public function registerEmployer(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,email_verified_at,NULL',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Check if user exists but is unverified
        $user = User::where('email', $validated['email'])->whereNull('email_verified_at')->first();

        if ($user) {
            // Update existing unverified user
            $user->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'role' => 'employer',
            ]);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'employer',
            ]);
        }

        // Set up the employer profile if it doesn't exist
        $employer = $user->employerProfile ?? new Employer();
        if (!$user->employerProfile) {
            $employer->user_id = $user->id;
            $employer->full_name = $validated['name'];
            $employer->setup_completed = false;
            $employer->save();
            $user->refresh();
        }

        // Fire registered event
        event(new Registered($user));

        // Mark as pending setup
        session(['pending_setup' => 'employer']);

        // Generate and send OTP
        try {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in session
            session([
                'otp_' . $user->email => $otp,
                'otp_expires_at_' . $user->email => now()->addMinutes(10),
                'requires_otp_verification' => true
            ]);

            // Create verification link
            $verificationLink = route('otp.verify.page', ['email' => $user->email]);

            // Send OTP email directly (no queue)
            Mail::to($user->email)->send(new OtpMail($user->email, $otp, $verificationLink));
        } catch (\Exception $e) {
            // Continue with redirection even if email fails
        }

        // Log the user in but mark as requiring OTP verification
        Auth::login($user);
        session(['requires_otp_verification' => true]);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify.page', ['email' => $user->email])
            ->with('message', 'Please verify your email to continue with setup.');
    }

    /**
     * =========================================================================
     * Dashboard Methods
     * =========================================================================
     */

    /**
     * Show the applicant dashboard
     */
    public function applicantDashboard()
    {
        return view('applicant.dashboard');
    }

    /**
     * Show the employer dashboard
     */
    public function employerDashboard()
    {
        return view('employer.dashboard');
    }

    /**
     * =========================================================================
     * Authentication Shared Methods
     * =========================================================================
     */

    /**
     * Log the user out of the application
     */
    public function logout(Request $request)
    {
        // Clear OTP related session data if present
        if (Auth::check()) {
            $email = Auth::user()->email;
            session()->forget(['otp_' . $email, 'otp_expires_at_' . $email]);
        }

        // Clear any verification flags
        session()->forget(['requires_otp_verification', 'pending_setup']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
