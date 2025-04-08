<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $userType = request()->get('user_type', 'applicant');
        session()->put('google_user_type', $userType);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $userType = session()->get('google_user_type', 'applicant');
            session()->forget('google_user_type');

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'is_employer' => ($userType === 'employer'),
                    'social_id' => $googleUser->getId(),
                    'social_type' => 'google'
                ]);

                Log::info('New user created', [
                    'user_id' => $user->id,
                    'is_employer' => $user->is_employer,
                    'social_id' => $user->social_id,
                    'social_type' => $user->social_type
                ]);

                // Create profile based on user type
                if ($userType === 'employer') {
                    $user->employer()->create([
                        'full_name' => $user->name,
                        'setup_completed' => false
                    ]);
                } else {
                    $user->applicantProfile()->create([
                        'full_name' => $user->name,
                        'setup_completed' => false
                    ]);
                }
            } else {
                Log::info('Existing user found', [
                    'user_id' => $user->id,
                    'is_employer' => $user->is_employer,
                    'social_id' => $user->social_id,
                    'social_type' => $user->social_type
                ]);

                // Update existing user's social login info if not set
                if (!$user->social_id) {
                    $user->update([
                        'social_id' => $googleUser->getId(),
                        'social_type' => 'google'
                    ]);
                    Log::info('Updated user with Google ID', [
                        'user_id' => $user->id,
                        'social_id' => $googleUser->getId(),
                        'social_type' => 'google'
                    ]);
                }

                // Don't change user type for existing users
                // This prevents changing from employer to applicant or vice versa
                Log::info('Keeping existing user type', [
                    'user_id' => $user->id,
                    'current_type' => $user->is_employer ? 'employer' : 'applicant',
                    'requested_type' => $userType
                ]);
            }

            // Login the user
            Auth::login($user);

            // Clear any existing session data
            session()->forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure middleware picks up the changes
            session()->regenerate();

            // If it's a new employer or applicant, redirect to setup
            if ($userType === 'employer' && !$user->employer?->setup_completed) {
                // Set a flag in the session to bypass middleware check
                session()->put('employer_setup_completed', true);
                Log::info('Redirecting to employer setup', [
                    'user_id' => $user->id
                ]);
                return redirect()->route('employer.setup');
            } elseif ($userType === 'applicant' && !$user->applicantProfile?->setup_completed) {
                // Set a flag in the session to bypass middleware check
                session()->put('applicant_setup_completed', true);
                Log::info('Redirecting to applicant setup', [
                    'user_id' => $user->id
                ]);
                return redirect()->route('applicant.setup');
            }

            // Otherwise, redirect to dashboard
            Log::info('Redirecting to dashboard', [
                'user_id' => $user->id,
                'user_type' => $userType
            ]);
            return redirect()->route($userType . '.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }
}
