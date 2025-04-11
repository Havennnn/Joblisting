<?php

namespace App\Http\Controllers\Settings\ChangeEmail;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;

class InitiateChangeController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Initiate email change process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
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
     * Generate OTP for email change verification
     */
    protected function generateOtpForEmailChange($user, $newEmail)
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
}
