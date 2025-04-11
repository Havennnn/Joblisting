<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadResumeController extends Controller
{
    /**
     * Download the resume for the application
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke($id)
    {
        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        if (!$application->resume_path) {
            return redirect()->back()->with('error', 'No resume attached to this application.');
        }

        // Mark as viewed if not already
        if (!$application->viewed_at) {
            $application->viewed_at = now();
            $application->save();
        }

        return Storage::download($application->resume_path, 'resume-' . $application->applicant->name . '.pdf');
    }
}
