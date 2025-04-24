<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\CompanyInvitation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CancelInviteController extends CompanyController
{
    /**
     * Cancel an invitation
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int $id): RedirectResponse
    {
        if (!$this->company) {
            return redirect()->route('employer.company.index');
        }

        $invitation = CompanyInvitation::where('id', $id)
            ->where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $invitation->status = 'cancelled';
        $invitation->save();

        return back()->with('success', 'Invitation cancelled successfully.');
    }
}
