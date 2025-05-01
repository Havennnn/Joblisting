<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interviews\Interview;
use App\Models\Jobs\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\InterviewResponseSubmitted;

class InterviewResponseController extends Controller
{
    /**
     * Accept an interview invitation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $interviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Request $request, $interviewId)
    {
        $applicant = Auth::user();

        // Find the interview that belongs to the authenticated applicant
        $interview = Interview::where('id', $interviewId)
            ->where('applicant_id', $applicant->id)
            ->firstOrFail();

        // Update the interview status
        $interview->status = 'accepted';
        $interview->save();

        // Update related job application status
        $jobApplication = JobApplication::where('job_id', $interview->job_id)
            ->where('applicant_id', $applicant->id)
            ->first();

        if ($jobApplication) {
            $jobApplication->interview_status = 'accepted';
            $jobApplication->save();
        }

        // Notify the employer that the interview was accepted
        if (method_exists($interview->employer, 'notify')) {
            $interview->employer->notify(new InterviewResponseSubmitted($interview, 'accepted'));
        }

        return redirect()->route('applicant.interviews.index')
            ->with('success', 'Interview accepted successfully! The interview has been added to your calendar.');
    }

    /**
     * Decline an interview invitation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $interviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Request $request, $interviewId)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $applicant = Auth::user();

        // Find the interview that belongs to the authenticated applicant
        $interview = Interview::where('id', $interviewId)
            ->where('applicant_id', $applicant->id)
            ->firstOrFail();

        // Update related job application status
        $jobApplication = JobApplication::where('job_id', $interview->job_id)
            ->where('applicant_id', $applicant->id)
            ->first();

        if ($jobApplication) {
            $jobApplication->interview_status = 'declined';
            $jobApplication->save();
        }

        // Notify the employer that the interview was declined
        if (method_exists($interview->employer, 'notify')) {
            $interview->employer->notify(new InterviewResponseSubmitted($interview, 'declined'));
        }

        return redirect()->route('applicant.applications')
            ->with('success', 'Interview declined successfully.');
    }
}
