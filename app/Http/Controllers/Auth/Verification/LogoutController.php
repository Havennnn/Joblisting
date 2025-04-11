<?php

namespace App\Http\Controllers\Auth\Verification;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out of the application
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
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
