<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpPageRequest;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyOtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Verify OTP and proceed with appropriate action
     *
     * @param \App\Http\Requests\VerifyOtpPageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(VerifyOtpPageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $email = $validated['email'];
        $otp = $validated['otp'];

        $user = $this->otpService->verifyOtp($email, $otp);

        if (!$user) {
            // Get the current timer value from session
            $otpCooldownKey = 'otp_requested_at_' . $user->id;
            $lastOtpTime = session($otpCooldownKey);
            $remainingTime = $lastOtpTime ? max(0, 60 - now()->diffInSeconds($lastOtpTime)) : 60;

            return back()
                ->with('otp_timer', $remainingTime)
                ->withErrors(['otp' => 'Invalid code or expired OTP.']);
        }

        // Mark email as verified if it wasn't
        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        // Check if user is already logged in (should be with the new approach)
        if (!Auth::check()) {
            // Log the user in if not already logged in
            Auth::login($user);
        }

        // Clear the OTP verification requirement
        session()->forget('requires_otp_verification');

        // Check if this is part of a setup flow
        $pendingSetup = session('pending_setup');
        if ($pendingSetup) {
            session()->forget('pending_setup');

            if ($pendingSetup === 'applicant') {
                return redirect()->route('applicant.setup');
            } elseif ($pendingSetup === 'employer') {
                return redirect()->route('employer.setup');
            }
        }

        // If no pending setup but user is not verified, redirect to setup
        if (!$user->email_verified_at) {
            if ($user->isEmployer()) {
                return redirect()->route('employer.setup');
            }
            return redirect()->route('applicant.setup');
        }

        // Only redirect to dashboard if user is already verified
        if ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        }
        return redirect()->route('applicant.dashboard');
    }
}
