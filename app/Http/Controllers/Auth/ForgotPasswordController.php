<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\Applicant\ForgotPasswordController as ApplicantForgotPasswordController;
use App\Http\Controllers\Auth\Employer\ForgotPasswordController as EmployerForgotPasswordController;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected $applicantForgotPasswordController;
    protected $employerForgotPasswordController;

    public function __construct(
        ApplicantForgotPasswordController $applicantForgotPasswordController,
        EmployerForgotPasswordController $employerForgotPasswordController
    ) {
        $this->applicantForgotPasswordController = $applicantForgotPasswordController;
        $this->employerForgotPasswordController = $employerForgotPasswordController;
    }

    /**
     * Show the forgot password form for applicants
     */
    public function showApplicantForm()
    {
        return $this->applicantForgotPasswordController->showForm();
    }

    /**
     * Process the applicant forgot password request
     */
    public function sendApplicantResetLink(Request $request)
    {
        return $this->applicantForgotPasswordController->sendResetLink($request);
    }

    /**
     * Show the forgot password form for employers
     */
    public function showEmployerForm()
    {
        return $this->employerForgotPasswordController->showForm();
    }

    /**
     * Process the employer forgot password request
     */
    public function sendEmployerResetLink(Request $request)
    {
        return $this->employerForgotPasswordController->sendResetLink($request);
    }

    /**
     * Show the OTP reset form
     */
    public function showResetForm(Request $request)
    {
        // Check if the request is for an employer or applicant
        if ($request->has('type') && $request->type === 'employer') {
            return $this->employerForgotPasswordController->showResetForm($request);
        }

        return $this->applicantForgotPasswordController->showResetForm($request);
    }

    /**
     * Reset the password using OTP
     */
    public function resetPassword(Request $request)
    {
        // Check if the request is for an employer or applicant
        if ($request->has('type') && $request->type === 'employer') {
            return $this->employerForgotPasswordController->resetPassword($request);
        }

        return $this->applicantForgotPasswordController->resetPassword($request);
    }
}
