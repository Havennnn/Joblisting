<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Users\User;
use App\Notifications\CompanyInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SendInviteController extends CompanyController
{
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

        $invitation = new CompanyInvitation();
        $invitation->company_id = $this->company->id;
        $invitation->email = $validated['email'];
        $invitation->name = $existingUser ? $existingUser->name : null;
        $invitation->token = Str::random(64);
        $invitation->created_by = $this->user->id;
        $invitation->status = 'pending';
        $invitation->save();

        try {
            if ($existingUser) {
                $existingUser->notify(new CompanyInvitationNotification($invitation));
            } else {
                Notification::route('mail', [
                    $validated['email'] => $existingUser ? $existingUser->name : 'Invited Employer',
                ])->notify(new CompanyInvitationNotification($invitation));
            }

            if ($existingUser) {
                $existingUser->notifications()->create([
                    'type' => 'App\Notifications\CompanyInvitationNotification',
                    'data' => [
                        'type' => 'company_invitation',
                        'invitation_id' => $invitation->id,
                        'company_id' => $this->company->id,
                        'company_name' => $this->company->name,
                        'sender_name' => $this->user->name,
                        'token' => $invitation->token,
                    ],
                ]);
            }

            return back()->with('success', 'Invitation sent successfully to ' . $validated['email']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation. Please try again later.');
        }
    }
}
