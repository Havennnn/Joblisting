<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Users\Employer;
use App\Models\Users\User;
use App\Notifications\CompanyInvitationNotification;
use App\Notifications\InvitationAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    /**
     * Display the invitation form
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $company = Auth::user()->employer->company;

        if (!$company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must create a company before inviting others.');
        }

        $pendingInvitations = CompanyInvitation::where('company_id', $company->id)
            ->where('status', 'pending')
            ->get();

        return view('employer.company.invite', compact('company', 'pendingInvitations'));
    }

    /**
     * Send an invitation to join the company
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $company = Auth::user()->employer->company;

        if (!$company) {
            return back()->with('error', 'You must create a company before inviting others.');
        }

        // Check if email is already associated with the company
        $existingUser = User::where('email', $validated['email'])->first();

        // If the user exists, check their role and company association
        if ($existingUser) {
            // Check if user is not an employer
            if (!$existingUser->isEmployer()) {
                return back()->with('error', 'This email belongs to a user who is not registered as an employer.');
            }

            // Check if already in this company
            if ($existingUser->employer && $existingUser->employer->company_id == $company->id) {
                return back()->with('error', 'This person is already part of your company.');
            }

            // Check if the user is already in another company
            if ($existingUser->employer && $existingUser->employer->company_id) {
                $otherCompany = Company::find($existingUser->employer->company_id);
                if ($otherCompany) {
                    return back()->with('error', 'This employer is already associated with "' . $otherCompany->name . '". They must leave their current company before joining yours.');
                } else {
                    return back()->with('error', 'This employer is already associated with another company. They must leave their current company before joining yours.');
                }
            }
        }

        // Check for existing pending invitation
        $existingInvitation = CompanyInvitation::where('email', $validated['email'])
            ->where('company_id', $company->id)
            ->where('status', 'pending')
            ->first();

        if ($existingInvitation) {
            return back()->with('error', 'An invitation has already been sent to this email.');
        }

        // Create invitation
        $invitation = new CompanyInvitation();
        $invitation->company_id = $company->id;
        $invitation->email = $validated['email'];
        $invitation->name = $existingUser ? $existingUser->name : null;
        $invitation->token = Str::random(64);
        $invitation->created_by = Auth::id();
        $invitation->status = 'pending';
        $invitation->save();

        // Send notification to the invited user
        try {
            if ($existingUser) {
                // If user exists, send notification directly to them
                $existingUser->notify(new CompanyInvitationNotification($invitation));
            } else {
                // Otherwise, send a notification to the email
                Notification::route('mail', [
                    $validated['email'] => $existingUser ? $existingUser->name : 'Invited Employer',
                ])->notify(new CompanyInvitationNotification($invitation));
            }

            // Create notification for existing user if they have a database connection
            if ($existingUser) {
                // Add to database notifications
                $existingUser->notifications()->create([
                    'type' => 'App\Notifications\CompanyInvitationNotification',
                    'data' => [
                        'type' => 'company_invitation',
                        'invitation_id' => $invitation->id,
                        'company_id' => $company->id,
                        'company_name' => $company->name,
                        'sender_name' => Auth::user()->name,
                        'token' => $invitation->token,
                    ],
                ]);
            }

            return back()->with('success', 'Invitation sent successfully to ' . $validated['email']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation. Please try again later.');
        }
    }

    /**
     * Accept a company invitation
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept($token)
    {
        $invitation = CompanyInvitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        // Check if user is logged in
        if (!Auth::check()) {
            // Store token in session and redirect to login
            session(['company_invitation_token' => $token]);
            return redirect()->route('login')
                ->with('info', 'Please log in or register to accept the company invitation.');
        }

        $user = Auth::user();

        // Verify user has employer profile
        if (!$user->employer) {
            return redirect()->route('employer.setup.index')
                ->with('info', 'Please complete your employer profile before accepting this invitation.');
        }

        // Check if user is already associated with a company
        if ($user->employer->company_id) {
            $currentCompany = Company::find($user->employer->company_id);
            $invitingCompany = Company::find($invitation->company_id);

            $companyName = $currentCompany ? $currentCompany->name : 'a company';
            $invitingCompanyName = $invitingCompany ? $invitingCompany->name : 'the inviting company';

            return redirect()->route('employer.company.index')
                ->with('error', "You are already part of {$companyName}. You must leave your current company before you can join {$invitingCompanyName}.");
        }

        // Update user's employer record
        $user->employer->company_id = $invitation->company_id;
        $user->employer->save();

        // Mark invitation as accepted
        $invitation->status = 'accepted';
        $invitation->accepted_by = $user->id;
        $invitation->accepted_at = now();
        $invitation->save();

        // Notify the creator that the invitation was accepted
        $creator = User::find($invitation->created_by);
        if ($creator) {
            try {
                $creator->notify(new InvitationAccepted($invitation, $user));
            } catch (\Exception $e) {
                // Continue with acceptance even if notification fails
            }
        }

        return redirect()->route('employer.company.index')
            ->with('success', 'You have successfully joined ' . $invitation->company->name . '.');
    }

    /**
     * Cancel an invitation
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($id)
    {
        $company = Auth::user()->employer->company;

        if (!$company) {
            return redirect()->route('employer.company.index');
        }

        $invitation = CompanyInvitation::where('id', $id)
            ->where('company_id', $company->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $invitation->status = 'cancelled';
        $invitation->save();

        return back()->with('success', 'Invitation cancelled successfully.');
    }
}
