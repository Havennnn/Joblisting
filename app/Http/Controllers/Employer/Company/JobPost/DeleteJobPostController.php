<?php

namespace App\Http\Controllers\Employer\Company\JobPost;

use App\Http\Controllers\Employer\Company\CompanyController;
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
        if (!$this->company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must belong to a company to perform this action.');
        }

        $companyEmployerIds = $this->company->employers()->pluck('id')->toArray();
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        if (!$this->isOwner && $jobPost->employer_id !== $this->employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to delete this job post.');
        }

        $jobPost->delete();

        return redirect()->route('employer.company.index')
            ->with('success', 'Job post has been deleted successfully.');
    }
}
