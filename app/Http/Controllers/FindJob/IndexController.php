<?php

namespace App\Http\Controllers\FindJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Display a listing of all job posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        $jobs = JobPost::with('employer.user')
                        ->where('auto_delete_at', '>', now())
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        return view('web.jobs.index', compact('jobs'));
    }
}
