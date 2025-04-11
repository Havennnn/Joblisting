<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of jobs for the landing page area
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $jobs = JobPost::orderBy('created_at', 'DESC')->get();

        return view('landing.jobs', compact('jobs'));
    }

    /**
     * Display the specified job details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id): View
    {
        $job = JobPost::findOrFail($id);

        return view('landing.job-details', compact('job'));
    }
}
