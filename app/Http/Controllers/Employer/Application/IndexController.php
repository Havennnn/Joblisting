<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display a listing of all applications for the employer
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $employer = Auth::user()->employer;
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        $applications = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->latest()
            ->paginate(10);

        return view('employer.applications.index', compact('applications', 'completionPercentage'));
    }
}
