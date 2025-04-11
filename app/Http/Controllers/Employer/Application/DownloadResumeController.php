<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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
            ->with('job')
            ->findOrFail($id);

        if (!$application->resume_path) {
            return redirect()->back()->with('error', 'No resume attached to this application.');
        }

        // Mark as viewed if not already and decrement the unread counter
        if (!$application->viewed_at) {
            DB::transaction(function () use ($application) {
                // Mark application as viewed
                $application->viewed_at = now();
                $application->save();

                // Decrement unread application count on the related job post
                $application->job()->decrement('unread_application_count');
            });
        }

        return Storage::download($application->resume_path, 'resume-' . $application->applicant->name . '.pdf');
    }
}
