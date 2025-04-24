<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Users\User;
use App\Services\CompanyInvitationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SendInviteController extends CompanyController
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
     * Send an invitation to join the company
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        if (!$this->company) {
            return back()->with('error', 'You must create a company before inviting others.');
        }

        $existingUser = User::where('email', $validated['email'])->first();

        if ($existingUser) {
            if (!$existingUser->isEmployer()) {
                return back()->with('error', 'This email belongs to a user who is not registered as an employer.');
            }

            if ($existingUser->employer && $existingUser->employer->company_id == $this->company->id) {
                return back()->with('error', 'This person is already part of your company.');
            }

            if ($existingUser->employer && $existingUser->employer->company_id) {
                $otherCompany = Company::find($existingUser->employer->company_id);
                if ($otherCompany) {
                    return back()->with('error', 'This employer is already associated with "' . $otherCompany->name . '". They must leave their current company before joining yours.');
                } else {
                    return back()->with('error', 'This employer is already associated with another company. They must leave their current company before joining yours.');
                }
            }
        }

        $existingInvitation = CompanyInvitation::where('email', $validated['email'])
            ->where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->first();

        if ($existingInvitation) {
            return back()->with('error', 'An invitation has already been sent to this email.');
        }

        try {
            // Create the invitation
            $invitation = $this->invitationService->createInvitation(
                $this->company->id,
                $validated['email'],
                $this->getTypedUser(),
                $existingUser ? $existingUser->name : null
            );

            // Send notification
            $this->invitationService->sendInvitationNotification($invitation, $existingUser);

            return back()->with('success', 'Invitation sent successfully to ' . $validated['email']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation. Please try again later.');
        }
    }
}
