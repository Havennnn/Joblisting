<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class EditController extends Controller
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
     * Show the form for editing the specified job post.
     */
    public function __invoke(string $id)
    {
        // Check if employer profile is complete enough (at least 70%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        if ($completionPercentage < 70) {
            return redirect()->route('employer.profile.edit')
                ->with('warning', 'Please complete your employer profile before editing a job post. Your profile is ' . $completionPercentage . '% complete.');
        }

        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->findOrFail($id);

        return view('JobPost.edit', compact('JobPost', 'completionPercentage'));
    }
}
