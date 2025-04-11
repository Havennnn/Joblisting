<?php

namespace App\Http\Controllers\Auth\SocialLogin;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleCallbackController extends Controller
{
    /**
     * Handle the callback from Google
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
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
                    'role' => ($userType === 'employer') ? 'employer' : 'applicant',
                    'social_id' => $googleUser->getId(),
                    'social_type' => 'google'
                ]);

                Log::info('New user created', [
                    'user_id' => $user->id,
                    'role' => $user->role,
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
                    'role' => $user->role,
                    'social_id' => $user->social_id,
                    'social_type' => $user->social_type
                ]);

                // Check if the user type matches the requested type
                $isEmployerMismatch = ($userType === 'employer' && !$user->isEmployer());
                $isApplicantMismatch = ($userType === 'applicant' && $user->isEmployer());

                if ($isEmployerMismatch || $isApplicantMismatch) {
                    Log::warning('User type mismatch', [
                        'user_id' => $user->id,
                        'role' => $user->role,
                        'requested_type' => $userType
                    ]);

                    // Redirect to appropriate login page with error
                    $errorMessage = $user->isEmployer()
                        ? 'This account is registered as an employer. Please use employer login.'
                        : 'This account is registered as an applicant. Please use applicant login.';

                    return redirect()->route($user->isEmployer() ? 'employer.login' : 'applicant.login')
                        ->with('error', $errorMessage);
                }

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
                    'current_type' => $user->role,
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
            Log::error('Google authentication failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'google_data' => isset($googleUser) ? [
                    'id' => $googleUser->getId() ?? null,
                    'email' => $googleUser->getEmail() ?? null,
                    'name' => $googleUser->getName() ?? null
                ] : null
            ]);

            if ($e instanceof \Illuminate\Database\QueryException) {
                return redirect()->route('login')
                    ->with('error', 'Database error during Google authentication. Please try again.');
            }

            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }
}
