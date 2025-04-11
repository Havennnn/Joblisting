<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowVerificationController extends Controller
{
    /**
     * Show OTP verification page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Get email from request or from authenticated user
        $email = $request->email ?? (Auth::check() ? Auth::user()->email : null);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Unable to verify email. Please try logging in again.');
        }

        return view('auth.otp-verify', ['email' => $email]);
    }
}
