<?php

namespace App\Http\Controllers\Employer\Company\JobPost;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Http\Controllers\Employer\Company\DeleteService;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeleteJobPostController extends CompanyController
{
    /**
     * Delete a job post
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int $id): RedirectResponse
    {
        $deleteService = new DeleteService();
        $result = $deleteService->deleteJobPost($id, $this->employer, $this->company, $this->isOwner);

        if ($result['success']) {
            return redirect()->route('employer.company.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->route('employer.company.index')
                ->with('error', $result['message']);
        }
    }
}
