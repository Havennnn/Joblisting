<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the user's job applications
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $applications = JobApplication::where('applicant_id', $user->id)
            ->with('job.employer')
            ->latest()
            ->paginate(10);

        return view('applicant.applications.index', compact('applications'));
    }

    /**
     * Store a new job application
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $job)
    {
        $user = Auth::user();
        $profile = $user->applicantProfile;
        $jobPost = JobPost::findOrFail($job);

        // Check if the user has already applied to this job
        $existingApplication = JobApplication::where('job_id', $jobPost->id)
            ->where('applicant_id', $user->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // Create new application
        $application = new JobApplication();
        $application->job_id = $jobPost->id;
        $application->applicant_id = $user->id;
        $application->employer_id = $jobPost->employer_id;
        $application->status = 'pending';
        $application->applied_at = now();

        // Attach resume if available
        if ($profile && $profile->resume_path) {
            $application->resume_path = $profile->resume_path;
        }

        $application->save();

        return redirect()->route('applicant.applications')->with('success', 'Your application has been submitted successfully!');
    }
}
