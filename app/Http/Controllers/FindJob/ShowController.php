<?php

namespace App\Http\Controllers\FindJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    /**
     * Display the specified job post
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke($id): View
    {
        $job = JobPost::with('employer.user')
                      ->findOrFail($id);

        return view('public.jobs.show', compact('job'));
    }
}
