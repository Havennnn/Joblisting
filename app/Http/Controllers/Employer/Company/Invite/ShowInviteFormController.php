<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Companies\CompanyInvitation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ShowInviteFormController extends CompanyController
{
    /**
     * Display the invitation form
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function __invoke(Request $request): View|RedirectResponse
    {
        if (!$this->company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must create a company before inviting others.');
        }

        $pendingInvitations = CompanyInvitation::where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->get();

        return view('employer.company.invite', [
            'company' => $this->company,
            'pendingInvitations' => $pendingInvitations
        ]);
    }
}
