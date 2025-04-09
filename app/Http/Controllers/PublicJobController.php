<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class PublicJobController extends Controller
{
    /**
     * Display a listing of all job posts
     */
    public function index()
    {
        $jobs = JobPost::orderBy('created_at', 'DESC')->get();

        return view('public.jobs.index', compact('jobs'));
    }

    /**
     * Display details of a job post
     */
    public function show($id)
    {
        $job = JobPost::findOrFail($id);

        return view('public.jobs.show', compact('job'));
    }
}
