<?php

namespace App\Http\Controllers\Employer\Company\JobPost;

use App\Http\Controllers\Employer\Company\CompanyController;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EditJobPostController extends CompanyController
{
    /**
     * Edit form for a job post within the company context
     *
     * @param Request $request
     * @param int $id
     * @return View|RedirectResponse
     */
    public function __invoke(Request $request, int $id): View|RedirectResponse
    {
        if (!$this->company) {
            return redirect()->route('employer.JobPost.edit', $id);
        }

        $companyEmployerIds = $this->company->employers()->pluck('id')->toArray();
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        if (!$this->isOwner && $jobPost->employer_id !== $this->employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to edit this job post.');
        }

        return view('employer.job-posts.edit', [
            'jobPost' => $jobPost,
            'company' => $this->company,
            'isOwner' => $this->isOwner
        ]);
    }
}
