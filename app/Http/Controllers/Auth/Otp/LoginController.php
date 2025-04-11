<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Process login and redirect to OTP page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
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

    /**
     * Send OTP with cooldown period
     *
     * @param \App\Models\Users\Users\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function sendOtpWithCooldown($user): RedirectResponse
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
}
