<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Process registration and redirect to OTP page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,email_verified_at,NULL',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            // If user exists but is unverified, allow updating details
            if (is_null($user->email_verified_at)) {
                $user->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                // If user is already verified, prevent re-registration
                return back()->withErrors(['email' => 'This email is already registered. Please log in.']);
            }
        }

        event(new Registered($user));

        $this->otpService->generateOtp($user);

        return redirect()->route('otp.verify.page', ['email' => $user->email]);
    }
}