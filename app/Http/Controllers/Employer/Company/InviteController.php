<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Users\Employer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            'name' => 'nullable|string|max:255',
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

            // Use the existing user's name if not provided
            if (empty($validated['name'])) {
                $validated['name'] = $existingUser->name;
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
        $invitation->name = $validated['name'] ?? 'Invited User';
        $invitation->token = Str::random(64);
        $invitation->created_by = Auth::id();
        $invitation->status = 'pending';
        $invitation->save();

        // TODO: Send email invitation
        // Mail::to($validated['email'])->send(new CompanyInvitation($invitation));

        return back()->with('success', 'Invitation sent successfully.');
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
            return redirect()->route('employer.company.index')
                ->with('error', 'You are already associated with a company. Leave your current company before accepting this invitation.');
        }

        // Update user's employer record
        $user->employer->company_id = $invitation->company_id;
        $user->employer->save();

        // Mark invitation as accepted
        $invitation->status = 'accepted';
        $invitation->accepted_by = $user->id;
        $invitation->accepted_at = now();
        $invitation->save();

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
