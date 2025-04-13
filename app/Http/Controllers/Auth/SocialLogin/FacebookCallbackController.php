<?php

namespace App\Http\Controllers\Auth\SocialLogin;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FacebookCallbackController extends Controller
{
    /**
     * Handle the callback from Facebook
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $userType = session()->get('facebook_user_type', 'applicant');
            session()->forget('facebook_user_type');

            Log::info('Facebook callback received', [
                'user_type' => $userType,
                'facebook_id' => $facebookUser->getId(),
                'email' => $facebookUser->getEmail(),
                'name' => $facebookUser->getName()
            ]);

            // Check if user exists
            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                Log::info('Creating new user from Facebook', [
                    'email' => $facebookUser->getEmail(),
                    'name' => $facebookUser->getName(),
                    'user_type' => $userType,
                    'facebook_id' => $facebookUser->getId()
                ]);

                try {
                    // Create new user
                    $userData = [
                        'name' => $facebookUser->getName(),
                        'email' => $facebookUser->getEmail(),
                        'password' => bcrypt(Str::random(24)),
                        'email_verified_at' => now(),
                        'role' => ($userType === 'employer') ? 'employer' : 'applicant',
                        'social_id' => $facebookUser->getId(),
                        'social_type' => 'facebook'
                    ];

                    Log::info('Attempting to create user with data', [
                        'user_data' => array_merge($userData, ['password' => '[HIDDEN]'])
                    ]);

                    $user = User::create($userData);

                    Log::info('New user created successfully', [
                        'user_id' => $user->id,
                        'role' => $user->role,
                        'social_id' => $user->social_id,
                        'social_type' => $user->social_type
                    ]);

                    // Create the appropriate profile based on user type
                    if ($userType === 'employer') {
                        $employer = $user->employer()->create([
                            'company_name' => $user->name . "'s Company",
                            'setup_completed' => false
                        ]);
                        Log::info('Employer profile created', [
                            'employer_id' => $employer->id
                        ]);
                    } else {
                        $applicant = $user->applicantProfile()->create([
                            'full_name' => $user->name,
                            'setup_completed' => false
                        ]);
                        Log::info('Applicant profile created', [
                            'applicant_id' => $applicant->id
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to create user: ' . $e->getMessage(), [
                        'exception' => $e,
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
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

                // Update existing user's Facebook ID if not set
                if (!$user->social_id) {
                    $user->update([
                        'social_id' => $facebookUser->getId(),
                        'social_type' => 'facebook'
                    ]);
                    Log::info('Updated user with Facebook ID', [
                        'user_id' => $user->id,
                        'social_id' => $facebookUser->getId(),
                        'social_type' => 'facebook'
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
            Log::info('User logged in', [
                'user_id' => $user->id,
                'role' => $user->role
            ]);

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
            Log::error('Facebook authentication failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'facebook_data' => isset($facebookUser) ? [
                    'id' => $facebookUser->getId() ?? null,
                    'email' => $facebookUser->getEmail() ?? null,
                    'name' => $facebookUser->getName() ?? null
                ] : null
            ]);

            // Handle database and other exceptions
            if ($e instanceof \Illuminate\Database\QueryException) {
                return redirect()->route('applicant.login')
                    ->with('error', 'Database error during Facebook authentication. Please try again.');
            }

            return redirect()->route('applicant.login')
                ->with('error', 'Facebook authentication failed. Please try again.');
        }
    }
}
