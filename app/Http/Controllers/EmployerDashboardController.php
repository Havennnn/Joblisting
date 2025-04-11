<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Users\ApplicantProfile;
use App\Models\Jobs\JobApplication;

class EmployerDashboardController extends Controller
{
    /**
     * Show the employer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $applicants = User::where('role', 'applicant')->latest()->take(5)->get(); // Get the latest 5 applicants
        return view('employer.dashboard', compact('applicants'));
    }

    public function employerDashboard()
    {
        // Fetching applicant statistics
        $totalApplicants = User::where('role', 'applicant')->count();
        $shortlistedApplicants = JobApplication::where('status', 'shortlisted')->count();
        $interviewsScheduled = JobApplication::where('status', 'interview_scheduled')->count();
        $pendingReview = JobApplication::where('status', 'pending')->count();

        // Fetching recent applicants (last 5)
        $recentApplicants = User::where('role', 'applicant')->latest()->take(5)->get();

        // Fetching client statistics - replace with whatever statistic you need
        $clientsToday = 0; // Replace with your model data
        $clientsThisWeek = 0; // Replace with your model data
        $clientsThisMonth = 0; // Replace with your model data

        return view('dashboard.employer', compact(
            'totalApplicants',
            'shortlistedApplicants',
            'interviewsScheduled',
            'pendingReview',
            'clientsToday',
            'clientsThisWeek',
            'clientsThisMonth',
            'recentApplicants' // Pass this variable to the view
        ));
    }

    /**
     * Show the list of all applicants.
     *
     * @return \Illuminate\View\View
     */
    public function viewApplicants()
    {
        // Retrieve all applicants
        $applicants = User::where('role', 'applicant')->get();

        // Return the applicants view
        return view('employer.applicants', compact('applicants'));
    }
}
