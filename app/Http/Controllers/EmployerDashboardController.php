<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Applicant;
use App\Models\Interview;

class EmployerDashboardController extends Controller
{
    /**
     * Show the employer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $applicants = Applicant::latest()->take(5)->get(); // Get the latest 5 applicants
        return view('employer.dashboard', compact('applicants'));
    }

    public function employerDashboard()
{
    // Fetching applicant statistics
    $totalApplicants = Applicant::count();
    $shortlistedApplicants = Applicant::where('status', 'shortlisted')->count();
    $interviewsScheduled = Applicant::where('status', 'interview_scheduled')->count();
    $pendingReview = Applicant::where('status', 'pending')->count();

    // Fetching recent applicants (last 5)
    $recentApplicants = Applicant::latest()->take(5)->get();

    // Fetching client statistics
    $clientsToday = Client::whereDate('created_at', today())->count();
    $clientsThisWeek = Client::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $clientsThisMonth = Client::whereMonth('created_at', now()->month)->count();

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
        $applicants = Applicant::all();

        // Return the applicants view
        return view('employer.applicants', compact('applicants'));
    }
}
