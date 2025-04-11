<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Settings\ChangeEmail\ShowFormController as EmailShowFormController;
use App\Http\Controllers\Settings\ChangeEmail\InitiateChangeController as EmailInitiateChangeController;
use App\Http\Controllers\Settings\ChangeEmail\ShowVerificationController as EmailShowVerificationController;
use App\Http\Controllers\Settings\ChangeEmail\VerifyChangeController as EmailVerifyChangeController;
use App\Http\Controllers\Settings\ChangePassword\ShowFormController as PasswordShowFormController;
use App\Http\Controllers\Settings\ChangePassword\UpdatePasswordController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $emailShowFormController;
    protected $emailInitiateChangeController;
    protected $emailShowVerificationController;
    protected $emailVerifyChangeController;
    protected $passwordShowFormController;
    protected $updatePasswordController;

    public function __construct(
        EmailShowFormController $emailShowFormController,
        EmailInitiateChangeController $emailInitiateChangeController,
        EmailShowVerificationController $emailShowVerificationController,
        EmailVerifyChangeController $emailVerifyChangeController,
        PasswordShowFormController $passwordShowFormController,
        UpdatePasswordController $updatePasswordController
    ) {
        $this->emailShowFormController = $emailShowFormController;
        $this->emailInitiateChangeController = $emailInitiateChangeController;
        $this->emailShowVerificationController = $emailShowVerificationController;
        $this->emailVerifyChangeController = $emailVerifyChangeController;
        $this->passwordShowFormController = $passwordShowFormController;
        $this->updatePasswordController = $updatePasswordController;
    }

    /**
     * Show the settings page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('settings.index');
    }

    /**
     * Show the email change form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showEmailChangeForm(): View
    {
        return $this->emailShowFormController->__invoke();
    }

    /**
     * Initiate email change process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function initiateEmailChange(Request $request): RedirectResponse
    {
        return $this->emailInitiateChangeController->__invoke($request);
    }

    /**
     * Show OTP verification page for email change
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showEmailChangeVerification()
    {
        return $this->emailShowVerificationController->__invoke();
    }

    /**
     * Verify OTP and complete email change
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmailChange(Request $request): RedirectResponse
    {
        return $this->emailVerifyChangeController->__invoke($request);
    }

    /**
     * Show the password change form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showPasswordChangeForm(): View
    {
        return $this->passwordShowFormController->__invoke();
    }

    /**
     * Update the user's password
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        return $this->updatePasswordController->__invoke($request);
    }
}
