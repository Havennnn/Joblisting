<?php

namespace App\Http\Controllers\Auth\Employer;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the forgot password form
     */
    public function showForm()
    {
        return view('auth.employer.forgot-password');
    }

    /**
     * Send the reset link email with OTP
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,role,employer',
        ], [
            'email.exists' => 'We could not find an employer account with that email address.'
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'employer')
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find an employer account with that email address.']);
        }

        // Generate and send OTP
        $this->otpService->generateOtp($user);

        // Store user email in session for the reset form
        Session::put('reset_email', $user->email);
        Session::put('reset_type', 'employer');

        // Redirect to the employer-specific reset password route
        return redirect()->route('employer.password.reset')
            ->with('status', 'We have emailed you a one-time password to reset your password.');
    }

    /**
     * Show the reset password form
     */
    public function showResetForm(Request $request)
    {
        $email = Session::get('reset_email');
        $resetType = Session::get('reset_type');

        if (!$email || $resetType !== 'employer') {
            return redirect()->route('content.unavailable', ['intended' => $request->path()])
                ->with('error', 'Invalid password reset session. Please start the password reset process again.');
        }

        return view('auth.employer.reset-password', [
            'email' => $email
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $email = $request->email;
        $otp = $request->otp;

        // Verify OTP
        $user = $this->otpService->verifyOtp($email, $otp);

        if (!$user || $user->role !== 'employer') {
            return back()->withErrors(['otp' => 'The one-time password is invalid or has expired.']);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear session data
        Session::forget(['reset_email', 'reset_type', 'otp_' . $email, 'otp_expires_at_' . $email]);

        return redirect()->route('employer.login')
            ->with('status', 'Your password has been reset successfully. You can now log in with your new password.');
    }
}
