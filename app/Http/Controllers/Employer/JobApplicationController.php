<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Dashboard\ProfileCompletionService;

class JobApplicationController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display a listing of all applications for the employer
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Auth::user()->employer;
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        $applications = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->latest()
            ->paginate(10);

        return view('employer.applications.index', compact('applications', 'completionPercentage'));
    }

    /**
     * Display applications for a specific job
     *
     * @param int $jobId
     * @return \Illuminate\Http\Response
     */
    public function showJobApplications($jobId)
    {
        $employer = Auth::user()->employer;
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        // Verify the job belongs to this employer
        $job = JobPost::where('id', $jobId)
            ->where('employer_id', $employer->id)
            ->firstOrFail();

        $applications = JobApplication::where('job_id', $jobId)
            ->with(['applicant.applicantProfile'])
            ->latest()
            ->paginate(10);

        return view('employer.applications.job', compact('applications', 'job', 'completionPercentage'));
    }

    /**
     * Display the specified application
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

    /**
     * Update the application status
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        $application->status = $request->status;

        if ($request->has('notes')) {
            $application->notes = $request->notes;
        }

        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Download the resume for the application
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadResume($id)
    {
        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        if (!$application->resume_path) {
            return redirect()->back()->with('error', 'No resume attached to this application.');
        }

        // Mark as viewed if not already
        if (!$application->viewed_at) {
            $application->viewed_at = now();
            $application->save();
        }

        return Storage::download($application->resume_path, 'resume-' . $application->applicant->name . '.pdf');
    }
}
