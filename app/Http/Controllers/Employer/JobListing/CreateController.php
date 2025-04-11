<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class CreateController extends Controller
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
     * Show the form for creating a new job post.
     */
    public function __invoke()
    {
        // Check if employer profile is complete enough (at least 70%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        if ($completionPercentage < 70) {
            return redirect()->route('employer.profile.edit')
                ->with('warning', 'Please complete your employer profile before posting a job. Your profile is ' . $completionPercentage . '% complete.');
        }

        return view('employer.job-posts.create', compact('completionPercentage'));
    }
}
