<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\CompanyInvitation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DeclineInviteController extends CompanyController
{
    /**
     * Decline a company invitation
     *
     * @param Request $request
     * @param string $token
     * @return RedirectResponse
     */
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $invitation = CompanyInvitation::where('token', $token)
            ->where('status', 'pending')
            ->where('email', Auth::user()->email)
            ->firstOrFail();

        $invitation->status = 'declined';
        $invitation->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'You have declined the invitation.');
    }
}
