<?php

namespace App\Http\Controllers\Applicant\MyApplications;

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
     * Display a listing of the user's job applications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $user = Auth::user();
        $applications = JobApplication::where('applicant_id', $user->id)
            ->with(['job.employer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get profile completion percentage
        $profileCompletionPercentage = $this->profileCompletionService->calculateApplicantCompletion($user);

        return view('applicant.applications.index', [
            'applications' => $applications,
            'profileCompletionPercentage' => $profileCompletionPercentage
        ]);
    }
}
