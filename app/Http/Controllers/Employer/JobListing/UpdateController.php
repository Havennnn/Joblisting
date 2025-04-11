<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class UpdateController extends Controller
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
     * Update the specified job post in storage.
     */
    public function __invoke(Request $request, string $id)
    {
        // Check if employer profile is complete enough (at least 70%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        if ($completionPercentage < 70) {
            return redirect()->route('employer.profile.edit')
                ->with('warning', 'Please complete your employer profile before updating a job post. Your profile is ' . $completionPercentage . '% complete.');
        }

        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'job_description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'work_setup' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'vacancies' => 'required|integer',
            'work_experience_level' => 'required|string|max:255',
            'educational_level' => 'required|string|max:255',
            'shift' => 'required|string|max:255',
            'tags' => 'nullable|string|max:255',
        ]);

        // Set default values for nullable fields
        $validatedData['salary'] = $validatedData['salary'] ?? 0;

        // Reset auto_delete_at to 7 days from now when updated
        $validatedData['auto_delete_at'] = now()->addDays(7);

        // Update the job post
        $JobPost->update($validatedData);

        return redirect()->route('employer.JobPost')->with('success', 'Job updated successfully');
    }
}
