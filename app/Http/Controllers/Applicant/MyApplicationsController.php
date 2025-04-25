<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\MyApplications\IndexController;
use App\Http\Controllers\Applicant\MyApplications\ApplyController;
use App\Models\Jobs\JobPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyApplicationsController extends Controller
{
    protected $indexController;
    protected $applyController;

    public function __construct(
        IndexController $indexController,
        ApplyController $applyController
    ) {
        $this->indexController = $indexController;
        $this->applyController = $applyController;
    }

    /**
     * Display a listing of the user's job applications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->indexController->__invoke();
    }

    /**
     * Apply for a job
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $job)
    {
        try {
            Log::debug('MyApplicationsController.store method called', [
                'job_id' => $job,
                'request_data' => $request->all()
            ]);

            // Validate input
            if (empty($job) || !is_numeric($job)) {
                Log::error('Invalid job ID provided', ['job_id' => $job]);
                return redirect()->route('applicant.dashboard')
                    ->with('error', 'Invalid job ID provided. Please try again with a valid job.');
            }

            // Verify that the job exists before applying
            $jobPost = JobPost::find($job);
            if (!$jobPost) {
                Log::error('Job posting not found', ['job_id' => $job]);
                return redirect()->route('applicant.dashboard')
                    ->with('error', 'Job posting not found or has been removed.');
            }

            // Verify that the job has an employer
            if (!$jobPost->employer_id) {
                Log::error('Job posting missing employer info', ['job_id' => $job, 'job_title' => $jobPost->title]);
                return redirect()->route('applicant.dashboard')
                    ->with('error', 'Cannot apply to this job posting due to missing employer information.');
            }

            Log::debug('Forwarding request to ApplyController', [
                'job_id' => $job,
                'job_title' => $jobPost->title,
                'employer_id' => $jobPost->employer_id
            ]);

            return $this->applyController->__invoke($request, $job);
        } catch (\Exception $e) {
            Log::error('Exception in MyApplicationsController.store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'An error occurred while processing your application. Please try again later.');
        }
    }
}
