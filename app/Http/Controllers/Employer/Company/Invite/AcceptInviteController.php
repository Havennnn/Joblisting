<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Users\User;
use App\Notifications\InvitationAccepted;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AcceptInviteController extends CompanyController
{
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

        $this->employer->company_id = $invitation->company_id;
        $this->employer->save();

        $invitation->status = 'accepted';
        $invitation->accepted_by = $this->user->id;
        $invitation->accepted_at = now();
        $invitation->save();

        $creator = User::find($invitation->created_by);
        if ($creator) {
            try {
                $creator->notify(new InvitationAccepted($invitation, $this->getTypedUser()));
            } catch (\Exception $e) {
                // Continue with acceptance even if notification fails
            }
        }

        return redirect()->route('employer.company.index')
            ->with('success', 'You have successfully joined ' . $invitation->company->name . '.');
    }
}
