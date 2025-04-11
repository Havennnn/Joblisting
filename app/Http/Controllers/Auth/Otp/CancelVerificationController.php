<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CancelVerificationController extends Controller
{
    /**
     * Cancel OTP verification process and clear session data
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
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
