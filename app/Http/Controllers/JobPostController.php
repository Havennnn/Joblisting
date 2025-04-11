<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobs\JobPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class JobPostController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $employer = Auth::user()->employer;
        $JobPosts = JobPost::where('employer_id', $employer->id)
                           ->orderBy('created_at', 'DESC')
                           ->get();

        // Get the employer profile completion percentage
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        return view('JobPost.index', compact('JobPosts', 'completionPercentage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if employer profile is complete enough (at least 70%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        if ($completionPercentage < 70) {
            return redirect()->route('employer.profile.edit')
                ->with('warning', 'Please complete your employer profile before posting a job. Your profile is ' . $completionPercentage . '% complete.');
        }

        return view('JobPost.create', compact('completionPercentage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if employer profile is complete enough (at least 70%)
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        if ($completionPercentage < 70) {
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
        $validatedData['employer_id'] = Auth::user()->employer->id;
        $validatedData['auto_delete_at'] = now()->addDays(7);

        // Create the job post
        JobPost::create($validatedData);

        return redirect()->route('employer.JobPost')->with('success', 'Job added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->with(['applications.applicant'])
                          ->findOrFail($id);

        // Get the employer profile completion percentage
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        // Calculate application statistics
        $totalApplications = $JobPost->applications->count();
        $newApplications = $JobPost->applications->where('viewed_at', null)->count();
        $reviewingApplications = $JobPost->applications->where('status', 'reviewing')->count();
        $acceptedApplications = $JobPost->applications->where('status', 'accepted')->count();
        $rejectedApplications = $JobPost->applications->where('status', 'rejected')->count();

        return view('JobPost.show', compact(
            'JobPost',
            'completionPercentage',
            'totalApplications',
            'newApplications',
            'reviewingApplications',
            'acceptedApplications',
            'rejectedApplications'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->findOrFail($id);

        $JobPost->delete();

        return redirect()->route('employer.JobPost')->with('success', 'Job deleted successfully');
    }
}

