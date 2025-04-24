<?php

namespace App\Http\Controllers\Employer\Company\Member;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Users\Employer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KickMemberController extends CompanyController
{
    /**
     * Kick a member from the company
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int $id): RedirectResponse
    {
        if (!$this->company || $this->employer->id === (int)$id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You cannot remove yourself from the company.');
        }

        $employer = Employer::findOrFail($id);

        if ($employer->company_id !== $this->company->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This employer is not a member of your company.');
        }

        $employer->company_id = null;
        $employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Member has been removed from the company.');
    }
}
