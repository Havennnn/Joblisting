<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Services\CompanyInvitationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AcceptInviteController extends CompanyController
{
    /**
     * @var CompanyInvitationService
     */
    protected $invitationService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(CompanyInvitationService $invitationService)
    {
        parent::__construct();
        $this->invitationService = $invitationService;
    }

    /**
     * Accept a company invitation
     *
     * @param Request $request
     * @param string $token
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $invitation = CompanyInvitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (!Auth::check()) {
            session(['company_invitation_token' => $token]);
            return redirect()->route('employer.login')
                ->with('info', 'Please log in or register to accept the company invitation.');
        }

        $this->setupUserAndCompany(); // Ensure user data is fresh

        if (!$this->employer) {
            return redirect()->route('employer.setup.index')
                ->with('info', 'Please complete your employer profile before accepting this invitation.');
        }

        if ($this->employer->company_id) {
            $currentCompany = Company::find($this->employer->company_id);
            $invitingCompany = Company::find($invitation->company_id);

            $companyName = $currentCompany ? $currentCompany->name : 'a company';
            $invitingCompanyName = $invitingCompany ? $invitingCompany->name : 'the inviting company';

            return redirect()->route('employer.company.index')
                ->with('error', "You are already part of {$companyName}. You must leave your current company before you can join {$invitingCompanyName}.");
        }

        // Update the employer's company ID
        $this->employer->company_id = $invitation->company_id;
        $this->employer->save();

        // Process the invitation acceptance
        $this->invitationService->acceptInvitation($invitation, $this->getTypedUser());

        return redirect()->route('employer.company.index')
            ->with('success', 'You have successfully joined ' . $invitation->company->name . '.');
    }
}
