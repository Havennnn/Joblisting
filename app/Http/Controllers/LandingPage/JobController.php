<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::orderBy('created_at', 'DESC')->get();

        return view('landing.jobs', compact('jobs'));
    }

    public function show($id)
    {
        $job = JobPost::findOrFail($id);

        return view('landing.job-details', compact('job'));
    }
}
