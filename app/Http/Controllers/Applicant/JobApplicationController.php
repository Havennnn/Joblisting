<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\User;
use App\Notifications\NewJobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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
        $jobPost = JobPost::with('employer.user')->findOrFail($job);

        // Debug info
        Log::info('Job Application Submitted', [
            'job_id' => $jobPost->id,
            'job_title' => $jobPost->title,
            'applicant_id' => $user->id,
            'applicant_name' => $user->name,
            'employer_id' => $jobPost->employer_id
        ]);

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

        // Load required relationships for the notification
        $application->load(['job', 'applicant']);

        // Find the employer's user account to send notification
        if ($jobPost->employer) {
            Log::info('Employer found', [
                'employer_id' => $jobPost->employer->id,
                'user_id' => $jobPost->employer->user_id ?? 'null'
            ]);

            try {
                // Approach 1: Get the employer's user directly from the user_id field
                $employerUser = User::find($jobPost->employer->user_id);

                if ($employerUser) {
                    Log::info('Sending notification to employer user', [
                        'employer_user_id' => $employerUser->id,
                        'employer_user_email' => $employerUser->email
                    ]);

                    // Send notification directly to the user model
                    $employerUser->notify(new NewJobApplication($application));
                    Log::info('Notification sent successfully to user');
                } else {
                    Log::warning('Employer user not found for employer ID: ' . $jobPost->employer->id);
                }

                // Approach 2: Use the Notification facade for direct send
                if ($jobPost->employer->user_id) {
                    Log::info('Sending notification via Notification facade');
                    Notification::send(
                        User::where('id', $jobPost->employer->user_id)->get(),
                        new NewJobApplication($application)
                    );
                    Log::info('Notification sent successfully via facade');
                }
            } catch (\Exception $e) {
                Log::error('Failed to send notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            Log::warning('Employer not found for job ID: ' . $jobPost->id);
        }

        return redirect()->route('applicant.applications')->with('success', 'Your application has been submitted successfully!');
    }
}
