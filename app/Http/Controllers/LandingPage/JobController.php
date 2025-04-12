<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Calculate profile completion percentage for applicants
        $profileCompletionPercentage = 100; // Default to 100% for non-applicants

        if (Auth::check() && Auth::user()->isApplicant()) {
            $applicant = Auth::user();
            $profile = $applicant->applicantProfile;

            if ($profile) {
                // Simple calculation - in a real app this would be more complex
                $profileCompletionPercentage = 100;

                // Reduce percentage for missing required fields
                if (empty($profile->phone_number)) $profileCompletionPercentage -= 20;
                if (empty($profile->location)) $profileCompletionPercentage -= 20;
                if (empty($profile->field)) $profileCompletionPercentage -= 20;
                if (empty($profile->skills)) $profileCompletionPercentage -= 20;
                if (empty($profile->resume_path)) $profileCompletionPercentage -= 20;
            } else {
                $profileCompletionPercentage = 0;
            }
        }

        return view('public.jobs.show', compact('job', 'profileCompletionPercentage'));
    }
}
