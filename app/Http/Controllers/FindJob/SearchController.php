<?php

namespace App\Http\Controllers\FindJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
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
        $location = $request->input('location');

        $jobsQuery = JobPost::query();

        // Apply search filters
        if ($query) {
            $jobsQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                  ->orWhere('job_description', 'like', "%$query%")
                  ->orWhere('employer_name', 'like', "%$query%");
            });
        }

        if ($location) {
            $jobsQuery->where('location', 'like', "%$location%");
        }

        $jobs = $jobsQuery->with('employer.user')
                          ->where('auto_delete_at', '>', now())
                          ->orderBy('created_at', 'DESC')
                          ->paginate(10);

        return view('web.jobs.index', compact('jobs', 'query', 'location'));
    }
}
