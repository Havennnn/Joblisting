<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\SocialLogin\GoogleRedirectController;
use App\Http\Controllers\Auth\SocialLogin\GoogleCallbackController;
use Illuminate\Http\RedirectResponse;

class GoogleController extends Controller
{
    protected $redirectController;
    protected $callbackController;

    public function __construct(
        GoogleRedirectController $redirectController,
        GoogleCallbackController $callbackController
    ) {
        $this->redirectController = $redirectController;
        $this->callbackController = $callbackController;
    }

    /**
     * Redirect the user to the Google authentication page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return $this->redirectController->__invoke();
    }

    /**
     * Handle the callback from Google
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        return $this->callbackController->__invoke();
    }
}
