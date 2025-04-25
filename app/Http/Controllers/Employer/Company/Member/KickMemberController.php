<?php

namespace App\Http\Controllers\Employer\Company\Member;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Http\Controllers\Employer\Company\DeleteService;
use App\Models\Users\Employer;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $deleteService = new DeleteService();
        $result = $deleteService->kickMember($id, $this->employer, $this->company);

        if ($result['success']) {
            return redirect()->route('employer.company.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->route('employer.company.index')
                ->with('error', $result['message']);
        }
    }
}
