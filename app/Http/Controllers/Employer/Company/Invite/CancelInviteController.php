<?php

namespace App\Http\Controllers\Employer\Company\Invite;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Http\Controllers\Employer\Company\DeleteService;
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
        $deleteService = new DeleteService();
        $result = $deleteService->cancelInvite($id, $this->company);

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
