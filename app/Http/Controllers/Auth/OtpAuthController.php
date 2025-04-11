<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use App\Http\Requests\VerifyOtpPageRequest;
use App\Http\Requests\ResendOtpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class OtpAuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    // Registration - Step 1: Show Registration Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registration - Step 2: Process Registration and Redirect to OTP Page
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,email_verified_at,NULL',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            // If user exists but is unverified, allow updating details
            if (is_null($user->email_verified_at)) {
                $user->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                // If user is already verified, prevent re-registration
                return back()->withErrors(['email' => 'This email is already registered. Please log in.']);
            }
        }

        event(new Registered($user));

        $this->otpService->generateOtp($user);

        return redirect()->route('otp.verify.page', ['email' => $user->email]);
    }

    // Login - Step 1: Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login - Step 2: Process Login and Redirect to OTP Page
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Log the user in but mark as requiring OTP verification
        Auth::login($user);
        session(['requires_otp_verification' => true]);

        return $this->sendOtpWithCooldown($user);
    }

    private function sendOtpWithCooldown($user)
    {
        $otpCooldownKey = 'otp_requested_at_' . $user->id;
        $lastOtpTime = session($otpCooldownKey);

        // If there's a last OTP time and it's been less than 1 minute
        if ($lastOtpTime && now()->diffInSeconds($lastOtpTime) < 60) {
            $remainingTime = 60 - now()->diffInSeconds($lastOtpTime);
            return back()->with('otp_timer', $remainingTime)
                ->with('status', 'Please wait before requesting a new OTP.');
        }

        // Store OTP request timestamp
        session([$otpCooldownKey => now()]);

        // Generate OTP and send email
        $this->otpService->generateOtp($user);

        return redirect()->route('otp.verify.page', ['email' => $user->email])
            ->with('otp_timer', 60)
            ->with('status', 'An OTP has been sent to your email.');
    }

    // Step 3: Show OTP Verification Page
    public function showOtpVerificationPage(Request $request)
    {
        // Get email from request or from authenticated user
        $email = $request->email ?? (Auth::check() ? Auth::user()->email : null);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Unable to verify email. Please try logging in again.');
        }

        return view('auth.otp-verify', ['email' => $email]);
    }

    // Step 4: Verify OTP
    public function verifyOtp(VerifyOtpPageRequest $request)
    {
        $validated = $request->validated();
        $email = $validated['email'];
        $otp = $validated['otp'];

        $user = $this->otpService->verifyOtp($email, $otp);

        if (!$user) {
            // Get the current timer value from session
            $otpCooldownKey = 'otp_requested_at_' . $user->id;
            $lastOtpTime = session($otpCooldownKey);
            $remainingTime = $lastOtpTime ? max(0, 60 - now()->diffInSeconds($lastOtpTime)) : 60;

            return back()
                ->with('otp_timer', $remainingTime)
                ->withErrors(['otp' => 'Invalid code or expired OTP.']);
        }

        // Mark email as verified if it wasn't
        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        // Check if user is already logged in (should be with the new approach)
        if (!Auth::check()) {
            // Log the user in if not already logged in
            Auth::login($user);
        }

        // Clear the OTP verification requirement
        session()->forget('requires_otp_verification');

        // Check if this is part of a setup flow
        $pendingSetup = session('pending_setup');
        if ($pendingSetup) {
            session()->forget('pending_setup');

            if ($pendingSetup === 'applicant') {
                return redirect()->route('applicant.setup');
            } elseif ($pendingSetup === 'employer') {
                return redirect()->route('employer.setup');
            }
        }

        // If no pending setup but user is not verified, redirect to setup
        if (!$user->email_verified_at) {
            if ($user->isEmployer()) {
                return redirect()->route('employer.setup');
            }
            return redirect()->route('applicant.setup');
        }

        // Only redirect to dashboard if user is already verified
        if ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        }
        return redirect()->route('applicant.dashboard');
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        return $this->sendOtpWithCooldown($user);
    }

    /**
     * Cancel OTP verification process and clear session data
     */
    public function cancelOtpVerification(Request $request)
    {
        $email = $request->input('email');

        // Clear OTP related session data
        if ($email) {
            session()->forget(['otp_' . $email, 'otp_expires_at_' . $email]);
        }

        // Clear any other registration/setup related session data
        session()->forget(['pending_setup', 'applicant_setup_completed', 'employer_setup_completed']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
