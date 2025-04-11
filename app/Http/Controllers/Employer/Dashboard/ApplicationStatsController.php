<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobs\JobApplication;
use App\Models\Jobs\JobPost;
use Illuminate\Support\Facades\DB;

class ApplicationStatsController extends Controller
{
    /**
     * Get application statistics for the dashboard
     */
    public function __invoke()
    {
        $employer = Auth::user()->employer;

        // Get the count of total and unread applications from job posts (more efficient)
        $jobPostStats = JobPost::where('employer_id', $employer->id)
            ->select(
                DB::raw('SUM(application_count) as total_applications'),
                DB::raw('SUM(unread_application_count) as unread_applications')
            )
            ->first();

        $totalApplications = $jobPostStats->total_applications ?? 0;
        $newApplications = $jobPostStats->unread_applications ?? 0;

        // Get applications by status
        $pendingApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'pending')
                                ->count();

        $reviewingApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'reviewing')
                                ->count();

        $acceptedApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'accepted')
                                ->count();

        return [
            'totalApplications' => $totalApplications,
            'newApplications' => $newApplications,
            'pendingApplications' => $pendingApplications,
            'reviewingApplications' => $reviewingApplications,
            'acceptedApplications' => $acceptedApplications
        ];
    }
}
