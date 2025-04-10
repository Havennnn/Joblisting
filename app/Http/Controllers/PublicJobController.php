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
        $jobs = JobPost::with('employer')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('public.jobs.index', compact('jobs'));
    }

    /**
     * Search for jobs based on title, location, or industry
     */
    public function search(Request $request)
    {
        $query = JobPost::with('employer');

        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('industry') && !empty($request->industry)) {
            $query->where('industry', 'like', '%' . $request->industry . '%');
        }

        $jobs = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('public.jobs.index', compact('jobs'));
    }

    /**
     * Display details of a job post
     */
    public function show($id)
    {
        $job = JobPost::with('employer')->findOrFail($id);

        return view('public.jobs.show', compact('job'));
    }
}
