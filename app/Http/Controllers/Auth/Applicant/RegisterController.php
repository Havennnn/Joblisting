<?php

namespace App\Http\Controllers\Auth\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\ApplicantProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the applicant registration form
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showRegistrationForm()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->role === 'employer') {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('auth.applicant.register');
    }

    /**
     * Handle a registration request for a new applicant
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,email_verified_at,NULL',
            'password' => 'required|string|confirmed|min:8|regex:/[A-Z]/|regex:/[0-9]/',
        ]);

        // Check if user exists but is unverified
        $user = User::where('email', $validated['email'])->whereNull('email_verified_at')->first();

        if ($user) {
            // Update existing unverified user
            $user->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
            ]);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'applicant',
            ]);
        }

        // Set up the applicant profile if it doesn't exist
        $applicant = $user->applicantProfile ?? new ApplicantProfile();
        if (!$user->applicantProfile) {
            $applicant->user_id = $user->id;
            $applicant->full_name = $validated['name'];
            $applicant->setup_completed = false;
            $applicant->save();
            $user->refresh();
        }

        // Fire registered event
        event(new Registered($user));

        // Mark as pending setup
        session(['pending_setup' => 'applicant']);

        // Generate and send OTP
        try {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in session
            session([
                'otp_' . $user->email => $otp,
                'otp_expires_at_' . $user->email => now()->addMinutes(10),
                'requires_otp_verification' => true
            ]);

            // Create verification link
            $verificationLink = route('otp.verify.page', ['email' => $user->email]);

            // Send OTP email directly (no queue)
            Mail::to($user->email)->send(new OtpMail($user->email, $otp, $verificationLink));
        } catch (\Exception $e) {
            // Continue with redirection even if email fails
            Log::error("Failed to send verification email: " . $e->getMessage());
        }

        // Log the user in but mark as requiring OTP verification
        Auth::login($user);
        session(['requires_otp_verification' => true]);

        // Redirect to OTP verification page
        return redirect()->route('otp.verify.page', ['email' => $user->email])
            ->with('message', 'Please verify your email to continue with setup.');
    }
}
