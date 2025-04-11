<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ShowJobApplicationsController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display applications for a specific job
     *
     * @param int $jobId
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke($jobId)
    {
        $employer = Auth::user()->employer;
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        // Verify the job belongs to this employer
        $job = JobPost::where('id', $jobId)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        $applications = JobApplication::where('job_id', $jobId)
            ->with(['applicant.applicantProfile'])
            ->latest()
            ->paginate(10);

        return view('employer.applications.job', compact('applications', 'job', 'completionPercentage'));
    }
}
