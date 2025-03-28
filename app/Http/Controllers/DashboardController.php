<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\SavedJob;

class DashboardController extends Controller
{
    public function index()
    {
        
        $applications = Application::all();

        $appliedCount = Application::count();
        $interviewedCount = Application::whereRaw('LOWER(interview_status) = ?', ['done'])->count();
        $interestedCount = SavedJob::count(); 
        
        return view('applicantDashboard', compact('applications', 'appliedCount', 'interviewedCount', 'interestedCount'));
    }
}
