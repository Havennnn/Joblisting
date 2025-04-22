<?php

namespace App\Http\Controllers\FindJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display the specified job post
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke($id): View
    {
        $job = JobPost::with('employer.user')
                      ->findOrFail($id);

        $profileCompletionPercentage = 0;

        // Only check profile completion for authenticated applicants
        if (Auth::check() && Auth::user()->role === 'applicant') {
            $profileCompletionPercentage = $this->profileCompletionService->calculateApplicantCompletion(Auth::user());
        }

        return view('web.jobs.show', compact('job', 'profileCompletionPercentage'));
    }
}
