<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use App\Models\Interviews\Interview;
use App\Notifications\ApplicationStatusChanged;
use App\Notifications\InterviewScheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleInterviewController extends Controller
{
    /**
     * Show the form for scheduling an interview
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function showForm($id)
    {
        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->findOrFail($id);

        return view('employer.applications.schedule-interview', compact('application'));
    }

    /**
     * Schedule an interview for the application
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schedule(Request $request, $id)
    {
        $request->validate([
            'interview_date' => 'required|date|after_or_equal:today',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url|max:255',
        ]);

        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        // Update application status to "to_be_interviewed"
        $oldStatus = $application->status;
        $application->status = 'to_be_interviewed';

        // Set interview_status to pending
        $application->interview_status = 'pending';
        $application->save();

        // Create interview record
        $interview = new Interview([
            'employer_id' => Auth::id(),
            'applicant_id' => $application->applicant_id,
            'job_id' => $application->job_id,
            'job_application_id' => $application->id,
            'interview_date' => $request->interview_date,
            'location' => $request->location,
            'meeting_link' => $request->meeting_link,
        ]);

        // Use try/catch to debug potential issues
        try {
            $interview->save();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error scheduling interview: ' . $e->getMessage())
                ->withInput();
        }

        // Send notification about status change if status changed
        if ($oldStatus !== $application->status) {
            $application->load(['job', 'applicant']); // Make sure relations are loaded
            $application->applicant->notify(new ApplicationStatusChanged($application));

            // If we had an InterviewScheduled notification, we'd send it here
            if (class_exists('App\\Notifications\\InterviewScheduled')) {
                $application->applicant->notify(new InterviewScheduled($interview));
            }
        }

        return redirect()->route('employer.applications.show', $id)
            ->with('success', 'Interview scheduled successfully');
    }
}
