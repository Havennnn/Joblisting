<?php

namespace App\Http\Controllers\Applicant\SavedJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Show all saved jobs for the current user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        $savedJobs = SavedJob::where('user_id', Auth::id())
            ->with(['job.employer.user'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('applicant.saved-jobs.index', compact('savedJobs'));
    }
}
