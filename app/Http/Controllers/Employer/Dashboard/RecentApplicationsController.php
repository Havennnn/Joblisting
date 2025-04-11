<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Jobs\JobApplication;

class RecentApplicationsController extends Controller
{
    /**
     * Get recent applications for the dashboard
     */
    public function __invoke()
    {
        $employer = Auth::user()->employer;

        // Get recent applications for the employer
        $recentApplications = JobApplication::where('employer_id', $employer->id)
                                    ->with(['job', 'applicant'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return $recentApplications;
    }
}
