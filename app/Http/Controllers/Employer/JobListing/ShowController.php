<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class ShowController extends Controller
{
    protected $profileCompletionService;

    /**
     * Constructor to inject the ProfileCompletionService.
     */
    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display the specified job post.
     */
    public function __invoke(string $id)
    {
        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->with(['applications.applicant'])
                          ->findOrFail($id);

        // Get the employer profile completion percentage
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        // Get application statistics directly from the model
        $totalApplications = $JobPost->application_count;
        $newApplications = $JobPost->unread_application_count;
        $reviewingApplications = $JobPost->applications->where('status', 'reviewing')->count();
        $acceptedApplications = $JobPost->applications->where('status', 'accepted')->count();
        $rejectedApplications = $JobPost->applications->where('status', 'rejected')->count();

        return view('employer.job-posts.show', compact(
            'JobPost',
            'completionPercentage',
            'totalApplications',
            'newApplications',
            'reviewingApplications',
            'acceptedApplications',
            'rejectedApplications'
        ));
    }
}
