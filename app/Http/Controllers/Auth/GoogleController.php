<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $userType = request()->get('user_type', 'applicant');

            // Check if user exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'type' => $userType,
                ]);
            }

            // Login the user
            Auth::login($user);

            // Redirect based on user type
            return redirect()->route($userType . '.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        }
    }
}
