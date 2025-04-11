<?php

namespace App\Http\Controllers\Applicant\MyApplications;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the user's job applications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $user = Auth::user();
        $applications = JobApplication::where('applicant_id', $user->id)
            ->with('job.employer')
            ->latest()
            ->paginate(10);

        return view('applicant.applications.index', compact('applications'));
    }
}
