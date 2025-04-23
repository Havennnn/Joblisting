<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class StoreController extends Controller
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
     * Store a newly created job post in storage.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $employer = $user->employer;

        // Check if employer has a company
        $hasCompany = !empty($employer->company_id);

        // Check if employer profile is complete enough (at least 90%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion($user);

        if ($completionPercentage < 90) {
            if (!$hasCompany) {
                return redirect()->route('employer.company.index')
                    ->with('warning', 'You need to create or join a company before posting a job. Your profile is ' . $completionPercentage . '% complete.');
            }

            return redirect()->route('employer.profile.edit')
                ->with('warning', 'Please complete your employer profile before posting a job. Your profile is ' . $completionPercentage . '% complete.');
        }

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
        $validatedData['employer_id'] = $employer->id;

        // Use company_id directly from the employer model
        if ($hasCompany) {
            $validatedData['company_id'] = $employer->company_id;
        }

        $validatedData['auto_delete_at'] = now()->addDays(7);

        // Create the job post
        JobPost::create($validatedData);

        return redirect()->route('employer.JobPost')->with('success', 'Job added successfully');
    }
}
