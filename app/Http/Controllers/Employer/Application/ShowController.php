<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
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
     * Display the specified application
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke($id)
    {
        $employer = Auth::user()->employer;
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        $application = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->findOrFail($id);

        // Mark as viewed if not already
        if (!$application->viewed_at) {
            $application->viewed_at = now();
            $application->save();
        }

        return view('employer.applications.show', compact('application', 'completionPercentage'));
    }
}
