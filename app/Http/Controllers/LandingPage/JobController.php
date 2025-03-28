<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        // We'll simplify here since the model might not exist yet
        $jobs = []; // Job::all();

        return view('landing.jobs', compact('jobs'));
    }

    public function show($id)
    {
        // We'll simplify here since the model might not exist yet
        $job = null; // Job::findOrFail($id);

        return view('landing.job-details', compact('job'));
    }
}
