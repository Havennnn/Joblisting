<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Applicant\LoginController as ApplicantLoginController;
use App\Http\Controllers\Auth\Applicant\RegisterController as ApplicantRegisterController;
use App\Http\Controllers\Auth\Employer\LoginController as EmployerLoginController;
use App\Http\Controllers\Auth\Employer\RegisterController as EmployerRegisterController;
use App\Http\Controllers\Auth\Dashboard\ApplicantDashboardController;
use App\Http\Controllers\Auth\Dashboard\EmployerDashboardController;
use App\Http\Controllers\Auth\Verification\LogoutController;
use App\Services\OtpService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $applicantLoginController;
    protected $applicantRegisterController;
    protected $employerLoginController;
    protected $employerRegisterController;
    protected $applicantDashboardController;
    protected $employerDashboardController;
    protected $logoutController;
    protected $otpService;

    public function __construct(
        ApplicantLoginController $applicantLoginController,
        ApplicantRegisterController $applicantRegisterController,
        EmployerLoginController $employerLoginController,
        EmployerRegisterController $employerRegisterController,
        ApplicantDashboardController $applicantDashboardController,
        EmployerDashboardController $employerDashboardController,
        LogoutController $logoutController,
        OtpService $otpService
    ) {
        $this->applicantLoginController = $applicantLoginController;
        $this->applicantRegisterController = $applicantRegisterController;
        $this->employerLoginController = $employerLoginController;
        $this->employerRegisterController = $employerRegisterController;
        $this->applicantDashboardController = $applicantDashboardController;
        $this->employerDashboardController = $employerDashboardController;
        $this->logoutController = $logoutController;
        $this->otpService = $otpService;
    }

    /**
     * =========================================================================
     * Applicant Login Methods
     * =========================================================================
     */

    /**
     * Show the applicant login form
     */
    public function showApplicantLogin()
    {
        return $this->applicantLoginController->showLoginForm();
    }

    /**
     * Handle an applicant login request
     */
    public function loginApplicant(Request $request)
    {
        return $this->applicantLoginController->login($request);
    }

    /**
     * =========================================================================
     * Employer Login Methods
     * =========================================================================
     */

    /**
     * Show the employer login form
     */
    public function showEmployerLogin()
    {
        return $this->employerLoginController->showLoginForm();
    }

    /**
     * Handle an employer login request
     */
    public function loginEmployer(Request $request)
    {
        return $this->employerLoginController->login($request);
    }

    /**
     * =========================================================================
     * Applicant Registration Methods
     * =========================================================================
     */

    /**
     * Show the applicant registration form
     */
    public function showApplicantRegister()
    {
        return $this->applicantRegisterController->showRegistrationForm();
    }

    /**
     * Handle a registration request for a new applicant
     */
    public function registerApplicant(Request $request)
    {
        return $this->applicantRegisterController->register($request);
    }

    /**
     * =========================================================================
     * Employer Registration Methods
     * =========================================================================
     */

    /**
     * Show the employer registration form
     */
    public function showEmployerRegister()
    {
        return $this->employerRegisterController->showRegistrationForm();
    }

    /**
     * Handle a registration request for a new employer
     */
    public function registerEmployer(Request $request)
    {
        return $this->employerRegisterController->register($request);
    }

    /**
     * =========================================================================
     * Dashboard Methods
     * =========================================================================
     */

    /**
     * Show the applicant dashboard
     */
    public function applicantDashboard()
    {
        return $this->applicantDashboardController->__invoke();
    }

    /**
     * Show the employer dashboard
     */
    public function employerDashboard()
    {
        return $this->employerDashboardController->__invoke();
    }

    /**
     * =========================================================================
     * Authentication Shared Methods
     * =========================================================================
     */

    /**
     * Log the user out of the application
     */
    public function logout(Request $request)
    {
        return $this->logoutController->__invoke($request);
    }
}
