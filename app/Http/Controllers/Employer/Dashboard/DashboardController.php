<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobs\Job;
use App\Models\Jobs\JobApplication;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the employer's dashboard.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $employer = $user->employer;

            // Get date range for stats
            $currentDate = Carbon::now();
            $startDate = $currentDate->copy()->startOfWeek();
            $endDate = $currentDate->copy()->endOfWeek();

            // Format dates for display
            $dateRange = [
                $startDate->format('M d'),
                $endDate->format('M d')
            ];

            // Get active job posts
            $activeJobs = $this->getActiveJobsCount($employer->id);

            // Get application statistics
            $applicationStats = $this->getApplicationStats($employer->id);

            // Get job statistics
            $jobStats = $this->getJobStats($employer->id, $startDate, $endDate);

            // Get recent applications
            $recentApplications = $this->getRecentApplications($employer->id);

            // Return view with data
            return $this->view('employer.dashboard', [
                'companyName' => $employer->company_name,
                'dateRange' => $dateRange,
                'activeJobs' => $activeJobs,
                'applicationStats' => $applicationStats,
                'jobStats' => $jobStats,
                'recentApplications' => $recentApplications
            ]);

        } catch (\Exception $e) {
            return $this->view('employer.dashboard', [
                'error' => 'Could not load dashboard data. ' . $e->getMessage(),
                'user' => Auth::user()
            ]);
        }
    }

    /**
     * Get count of active job posts for an employer.
     *
     * @param int $employerId
     * @return int
     */
    private function getActiveJobsCount($employerId)
    {
        return Job::where('employer_id', $employerId)
            ->where('status', 'active')
            ->count();
    }

    /**
     * Get application statistics for an employer.
     *
     * @param int $employerId
     * @return array
     */
    private function getApplicationStats($employerId)
    {
        // Get jobs owned by this employer
        $jobIds = Job::where('employer_id', $employerId)->pluck('id');

        // Total applications count
        $totalApplications = JobApplication::whereIn('job_id', $jobIds)->count();

        // Status counts
        $pendingApplications = JobApplication::whereIn('job_id', $jobIds)
            ->where('status', 'pending')
            ->count();

        $reviewingApplications = JobApplication::whereIn('job_id', $jobIds)
            ->where('status', 'reviewing')
            ->count();

        $acceptedApplications = JobApplication::whereIn('job_id', $jobIds)
            ->where('status', 'accepted')
            ->count();

        $rejectedApplications = JobApplication::whereIn('job_id', $jobIds)
            ->where('status', 'rejected')
            ->count();

        // New applications today
        $newApplications = JobApplication::whereIn('job_id', $jobIds)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Calculate percentages
        $pendingPercentage = $totalApplications > 0 ? round(($pendingApplications / $totalApplications) * 100) : 0;
        $reviewingPercentage = $totalApplications > 0 ? round(($reviewingApplications / $totalApplications) * 100) : 0;
        $acceptedPercentage = $totalApplications > 0 ? round(($acceptedApplications / $totalApplications) * 100) : 0;
        $rejectedPercentage = $totalApplications > 0 ? round(($rejectedApplications / $totalApplications) * 100) : 0;

        // Get count of active jobs
        $activeJobs = $this->getActiveJobsCount($employerId);

        return [
            'totalApplications' => $totalApplications,
            'pendingApplications' => $pendingApplications,
            'reviewingApplications' => $reviewingApplications,
            'acceptedApplications' => $acceptedApplications,
            'rejectedApplications' => $rejectedApplications,
            'newApplications' => $newApplications,
            'pendingPercentage' => $pendingPercentage,
            'reviewingPercentage' => $reviewingPercentage,
            'acceptedPercentage' => $acceptedPercentage,
            'rejectedPercentage' => $rejectedPercentage,
            'activeJobs' => $activeJobs
        ];
    }

    /**
     * Get job statistics for the dashboard.
     *
     * @param int $employerId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    private function getJobStats($employerId, $startDate, $endDate)
    {
        // In a real application, you would query the job views and application stats
        // For this example, we're returning sample data

        return [
            'jobViews' => [
                'total' => 4218,
                'percentageChange' => 12.3,
                'trend' => 'up', // 'up' or 'down'
            ],
            'applications' => [
                'total' => 843,
                'percentageChange' => 8.7,
                'trend' => 'up', // 'up' or 'down'
            ],
            // Daily stats for chart (in a real app, would be actual data)
            'daily' => [
                'mon' => ['views' => 120, 'applications' => 30],
                'tue' => ['views' => 85, 'applications' => 42],
                'wed' => ['views' => 160, 'applications' => 58],
                'thu' => ['views' => 145, 'applications' => 60],
                'fri' => ['views' => 110, 'applications' => 35],
                'sat' => ['views' => 65, 'applications' => 22],
                'sun' => ['views' => 90, 'applications' => 40],
            ]
        ];
    }

    /**
     * Get recent applications for an employer.
     *
     * @param int $employerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecentApplications($employerId)
    {
        // Get jobs owned by this employer
        $jobIds = Job::where('employer_id', $employerId)->pluck('id');

        // Get recent applications
        return JobApplication::whereIn('job_id', $jobIds)
            ->with(['applicant', 'job'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
}
