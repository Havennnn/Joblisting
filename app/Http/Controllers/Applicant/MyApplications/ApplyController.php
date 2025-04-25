<?php

namespace App\Http\Controllers\Applicant\MyApplications;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use App\Models\Jobs\JobPost;
use App\Models\Users\User;
use App\Notifications\NewJobApplication;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class ApplyController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Process a job application
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $job)
    {
        // Debug starting point
        Log::debug('ApplyController invoked', [
            'job_id' => $job,
            'user_id' => Auth::id()
        ]);

        try {
            $user = Auth::user();
            if (!$user) {
                Log::error('User not authenticated in ApplyController');
                return redirect()->route('login')->with('error', 'You must be logged in to apply for jobs.');
            }

            $profile = $user->applicantProfile;
            if (!$profile) {
                Log::error('User has no applicant profile', ['user_id' => $user->id]);
                return redirect()->route('applicant.profile')->with('error', 'You need to set up your applicant profile first.');
            }

            $jobPost = JobPost::with(['employer.user', 'company'])->find($job);
            if (!$jobPost) {
                Log::error('Job post not found', ['job_id' => $job]);
                return redirect()->route('applicant.dashboard')->with('error', 'The job posting was not found.');
            }

            // Check if profile is complete enough to apply
            $profileCompletionPercentage = $this->profileCompletionService->calculateApplicantCompletion($user);
            Log::debug('Profile completion check', [
                'user_id' => $user->id,
                'completion' => $profileCompletionPercentage
            ]);

            if ($profileCompletionPercentage < 100) {
                return redirect()->route('applicant.profile')->with('error',
                    'Your profile needs to be completed before you can apply to jobs. Current completion: ' . $profileCompletionPercentage . '%');
            }

            // Debug info
            Log::info('Job Application Submitted', [
                'job_id' => $jobPost->id,
                'job_title' => $jobPost->title,
                'applicant_id' => $user->id,
                'applicant_name' => $user->name,
                'employer_id' => $jobPost->employer_id,
                'company_id' => $jobPost->company_id ?? null
            ]);

            // Check if the user has already applied to this job
            $existingApplication = JobApplication::where('job_id', $jobPost->id)
                ->where('applicant_id', $user->id)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this job.');
            }

            // Begin transaction to ensure data consistency
            DB::beginTransaction();

            try {
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
                Log::debug('Application saved successfully', ['application_id' => $application->id]);

                // Increment application counters on the job post
                $jobPost->increment('application_count');
                $jobPost->increment('unread_application_count');

                // Commit the transaction
                DB::commit();
                Log::debug('Transaction committed successfully');

                // Load required relationships for the notification
                $application->load(['job', 'applicant']);

                // Find the employer's user account to send notification
                if ($jobPost->employer) {
                    Log::info('Employer found', [
                        'employer_id' => $jobPost->employer->id,
                        'user_id' => $jobPost->employer->user_id ?? 'null',
                        'company_id' => $jobPost->employer->company_id ?? 'null'
                    ]);

                    try {
                        // Get the employer's user directly from the user_id field
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
                    } catch (\Exception $e) {
                        Log::error('Failed to send notification', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    Log::warning('Employer not found for job ID: ' . $jobPost->id);
                }
            } catch (\Exception $e) {
                // If there's an error, rollback the transaction
                DB::rollBack();
                Log::error('Error saving application', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()->with('error', 'Error submitting application. Please try again.');
            }

            Log::debug('Redirecting to applications page with success message');
            return redirect()->route('applicant.applications')->with('success', 'Your application has been submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Unhandled exception in ApplyController', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
