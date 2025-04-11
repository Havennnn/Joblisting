<?php

namespace App\Http\Controllers\FindJob;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search job posts
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request): View
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
}
