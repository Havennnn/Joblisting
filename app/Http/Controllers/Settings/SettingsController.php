<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the settings page
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show the email change form
     */
    public function showEmailChangeForm()
    {
        return view('settings.email-change-form');
    }

    /**
     * Initiate email change process
     */
    public function initiateEmailChange(Request $request)
    {
        $request->validate([
            'new_email' => 'required|email|unique:users,email',
        ]);

        $user = Auth::user();
        $newEmail = $request->new_email;

        // Store the new email temporarily in session
        session(['pending_email_change' => $newEmail]);

        // Generate and send OTP to the new email
        $this->generateOtpForEmailChange($user, $newEmail);

        return redirect()->route('settings.email.verify');
    }

    /**
     * Show OTP verification page for email change
     */
    public function showEmailChangeVerification()
    {
        $newEmail = session('pending_email_change');

        if (!$newEmail) {
            return redirect()->route('settings.index')
                ->with('error', 'Email change request expired. Please try again.');
        }

        return view('settings.verify-email-change', ['email' => $newEmail]);
    }

    /**
     * Verify OTP and complete email change
     */
    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $newEmail = session('pending_email_change');
        $otp = $request->otp;

        if (!$newEmail) {
            return redirect()->route('settings.index')
                ->with('error', 'Email change request expired. Please try again.');
        }

        // Verify OTP
        $verified = $this->verifyOtpForEmailChange($user, $newEmail, $otp);

        if (!$verified) {
            return back()->withErrors(['otp' => 'Invalid OTP code or it has expired.']);
        }

        // Update email
        $user->email = $newEmail;
        $user->email_verified_at = now();
        $user->save();

        // Clear session
        session()->forget('pending_email_change');

        return redirect()->route('settings.index')
            ->with('success', 'Email address has been updated and verified.');
    }

    /**
     * Generate OTP for email change verification
     */
    protected function generateOtpForEmailChange(User $user, $newEmail)
    {
        $otp = rand(100000, 999999);

        // Store OTP in session with different key for email change
        session([
            'email_change_otp_' . $user->id => $otp,
            'email_change_otp_expires_at_' . $user->id => now()->addMinutes(10)
        ]);

        try {
            // Send OTP to the new email
            Log::info("Sending email change OTP to: " . $newEmail);
            Mail::to($newEmail)->send(new OtpMail($newEmail, $otp, route('settings.email.verify')));
            Log::info("Email change OTP sent successfully to: " . $newEmail);
        } catch (\Exception $e) {
            Log::error("Failed to send email change OTP: " . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    /**
     * Verify OTP for email change
     */
    protected function verifyOtpForEmailChange(User $user, $newEmail, $otp)
    {
        $storedOtp = session('email_change_otp_' . $user->id);
        $expiresAt = session('email_change_otp_expires_at_' . $user->id);

        if (!$storedOtp || !$expiresAt) {
            return false;
        }

        if (now()->isAfter($expiresAt)) {
            // OTP expired
            session()->forget(['email_change_otp_' . $user->id, 'email_change_otp_expires_at_' . $user->id]);
            return false;
        }

        if ((string)$storedOtp !== (string)$otp) {
            return false;
        }

        // Clear OTP from session after successful verification
        session()->forget(['email_change_otp_' . $user->id, 'email_change_otp_expires_at_' . $user->id]);

        return true;
    }
}
