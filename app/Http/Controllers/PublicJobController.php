<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class PublicJobController extends Controller
{
    /**
     * Display a listing of all job posts
     */
    public function index()
    {
        $jobs = JobPost::with('employer.user')
                        ->where('auto_delete_at', '>', now())
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        return view('public.jobs.index', compact('jobs'));
    }

    /**
     * Search job posts
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type');
        $location = $request->input('location');

        $jobsQuery = JobPost::query();

        // Apply search filters
        if ($query) {
            $jobsQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                  ->orWhere('job_description', 'like', "%$query%")
                  ->orWhere('tags', 'like', "%$query%");
            });
        }

        if ($type) {
            $jobsQuery->where('type', $type);
        }

        if ($location) {
            $jobsQuery->where('location', 'like', "%$location%");
        }

        $jobs = $jobsQuery->with('employer.user')
                          ->where('auto_delete_at', '>', now())
                          ->orderBy('created_at', 'DESC')
                          ->paginate(10);

        return view('public.jobs.index', compact('jobs', 'query', 'type', 'location'));
    }

    /**
     * Display the specified job post
     */
    public function show($id)
    {
        $job = JobPost::with('employer.user')
                      ->findOrFail($id);

        return view('public.jobs.show', compact('job'));
    }
}
