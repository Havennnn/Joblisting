<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the applicant's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Sample data - in a real application, you'd retrieve this from your database
        $recentJobs = [
            // Sample jobs
        ];

        $applications = [
            // Sample applications
        ];

        return view('applicant.dashboard', [
            'user' => $user,
            'recentJobs' => $recentJobs,
            'applications' => $applications,
        ]);
    }
}
