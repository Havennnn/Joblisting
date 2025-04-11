<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class ApplicationStatsController extends Controller
{
    /**
     * Get application statistics for the dashboard
     */
    public function __invoke()
    {
        $employer = Auth::user()->employer;

        // Get the count of total applications for the employer
        $totalApplications = JobApplication::where('employer_id', $employer->id)->count();

        // Get new/unread applications count
        $newApplications = JobApplication::where('employer_id', $employer->id)
                                ->whereNull('viewed_at')
                                ->count();

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
