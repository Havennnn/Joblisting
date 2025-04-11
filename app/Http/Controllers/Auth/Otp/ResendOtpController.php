<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResendOtpRequest;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;

class ResendOtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Resend OTP to the user
     *
     * @param \App\Http\Requests\ResendOtpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(ResendOtpRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        return $this->sendOtpWithCooldown($user);
    }

    /**
     * Send OTP with cooldown period
     *
     * @param \App\Models\User $user
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
