<?php

namespace App\Http\Controllers\Settings\ChangeEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyChangeController extends Controller
{
    /**
     * Verify OTP and complete email change
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
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
     * Verify OTP for email change
     */
    protected function verifyOtpForEmailChange($user, $newEmail, $otp)
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
