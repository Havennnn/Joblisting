<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\SocialLogin\FacebookRedirectController;
use App\Http\Controllers\Auth\SocialLogin\FacebookCallbackController;
use Illuminate\Http\RedirectResponse;

class FacebookController extends Controller
{
    protected $redirectController;
    protected $callbackController;

    public function __construct(
        FacebookRedirectController $redirectController,
        FacebookCallbackController $callbackController
    ) {
        $this->redirectController = $redirectController;
        $this->callbackController = $callbackController;
    }

    /**
     * Redirect the user to the Facebook authentication page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook(): RedirectResponse
    {
        return $this->redirectController->__invoke();
    }

    /**
     * Handle the callback from Facebook
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback(): RedirectResponse
    {
        return $this->callbackController->__invoke();
    }
}
