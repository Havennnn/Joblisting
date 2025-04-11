<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Otp\ShowRegisterFormController;
use App\Http\Controllers\Auth\Otp\RegisterController;
use App\Http\Controllers\Auth\Otp\ShowLoginFormController;
use App\Http\Controllers\Auth\Otp\LoginController;
use App\Http\Controllers\Auth\Otp\ShowVerificationController;
use App\Http\Controllers\Auth\Otp\VerifyOtpController;
use App\Http\Controllers\Auth\Otp\ResendOtpController;
use App\Http\Controllers\Auth\Otp\CancelVerificationController;
use App\Http\Requests\ResendOtpRequest;
use App\Http\Requests\VerifyOtpPageRequest;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpAuthController extends Controller
{
    protected $otpService;
    protected $showRegisterFormController;
    protected $registerController;
    protected $showLoginFormController;
    protected $loginController;
    protected $showVerificationController;
    protected $verifyOtpController;
    protected $resendOtpController;
    protected $cancelVerificationController;

    public function __construct(
        OtpService $otpService,
        ShowRegisterFormController $showRegisterFormController,
        RegisterController $registerController,
        ShowLoginFormController $showLoginFormController,
        LoginController $loginController,
        ShowVerificationController $showVerificationController,
        VerifyOtpController $verifyOtpController,
        ResendOtpController $resendOtpController,
        CancelVerificationController $cancelVerificationController
    ) {
        $this->otpService = $otpService;
        $this->showRegisterFormController = $showRegisterFormController;
        $this->registerController = $registerController;
        $this->showLoginFormController = $showLoginFormController;
        $this->loginController = $loginController;
        $this->showVerificationController = $showVerificationController;
        $this->verifyOtpController = $verifyOtpController;
        $this->resendOtpController = $resendOtpController;
        $this->cancelVerificationController = $cancelVerificationController;
    }

    /**
     * Show Registration Form
     */
    public function showRegisterForm()
    {
        return $this->showRegisterFormController->__invoke();
    }

    /**
     * Process Registration and Redirect to OTP Page
     */
    public function register(Request $request)
    {
        return $this->registerController->__invoke($request);
    }

    /**
     * Show Login Form
     */
    public function showLoginForm()
    {
        return $this->showLoginFormController->__invoke();
    }

    /**
     * Process Login and Redirect to OTP Page
     */
    public function login(Request $request)
    {
        return $this->loginController->__invoke($request);
    }

    /**
     * Show OTP Verification Page
     */
    public function showOtpVerificationPage(Request $request)
    {
        return $this->showVerificationController->__invoke($request);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(VerifyOtpPageRequest $request)
    {
        return $this->verifyOtpController->__invoke($request);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(ResendOtpRequest $request)
    {
        return $this->resendOtpController->__invoke($request);
    }

    /**
     * Cancel OTP verification process and clear session data
     */
    public function cancelOtpVerification(Request $request)
    {
        return $this->cancelVerificationController->__invoke($request);
    }
}
