<?php

namespace App\Http\Controllers\Auth\SocialLogin;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;

class GoogleRedirectController extends Controller
{
    /**
     * Redirect the user to the Google authentication page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $userType = request()->get('user_type', 'applicant');
        session()->put('google_user_type', $userType);
        return Socialite::driver('google')->redirect();
    }
}
