<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            $userType = request()->get('user_type', 'applicant');

            // Check if user exists
            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                // Download and store Facebook profile picture
                $profilePictureUrl = $facebookUser->getAvatar();
                $profilePictureContents = file_get_contents($profilePictureUrl);
                $filename = 'profile_pictures/' . Str::random(40) . '.jpg';
                Storage::disk('public')->put($filename, $profilePictureContents);

                // Create new user
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'type' => $userType,
                    'profile_picture' => $filename,
                ]);
            }

            // Login the user
            Auth::login($user);

            // If it's a new employer, redirect to setup
            if ($userType === 'employer' && !$user->setup_completed) {
                return redirect()->route('employer.setup');
            }

            // Otherwise, redirect to dashboard
            return redirect()->route($userType . '.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Facebook authentication failed. Please try again.');
        }
    }
}
