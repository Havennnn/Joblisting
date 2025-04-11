<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\Users\User;
use App\Jobs\SendOtpJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OtpService
{
    public function generateOtp(User $user)
    {
        Log::info("Generating OTP for user: " . $user->email);

        $otp = rand(100000, 999999);

        // Store OTP in session with user's email as part of the key to avoid conflicts
        session([
            'otp_' . $user->email => $otp,
            'otp_expires_at_' . $user->email => Carbon::now()->addMinutes(10)
        ]);

        // Store email in session for convenience
        session(['email' => $user->email]);

        $verificationLink = route('otp.verify.page', ['email' => $user->email]);

        try {
            // Send OTP email directly instead of queuing
            Log::info("Sending OTP email directly to: " . $user->email);
            Mail::to($user->email)->send(new OtpMail($user->email, $otp, $verificationLink));
            Log::info("OTP email successfully sent to: " . $user->email);
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email: " . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function verifyOtp($email, $otp)
    {
        $sessionOtp = session('otp_' . $email);
        $expiresAt = session('otp_expires_at_' . $email);

        if (!$sessionOtp || $sessionOtp != $otp || !$expiresAt || now()->greaterThan($expiresAt)) {
            Log::warning("OTP verification failed for {$email}. Valid OTP: " . ($sessionOtp ? 'Yes' : 'No') .
                ", Expired: " . ($expiresAt && now()->greaterThan($expiresAt) ? 'Yes' : 'No'));
            return false;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            Log::warning("User not found with email: {$email}");
            return false;
        }

        // clear OTP from session after successful verification
        session()->forget(['otp_' . $email, 'otp_expires_at_' . $email]);

        $user->update([
            'email_verified_at' => now(),
        ]);

        Log::info("OTP verified successfully for user: {$email}");
        return $user;
    }
}
