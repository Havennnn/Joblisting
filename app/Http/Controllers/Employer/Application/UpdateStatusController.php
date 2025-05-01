<?php

namespace App\Http\Controllers\Employer\Application;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobApplication;
use App\Notifications\ApplicationStatusChanged;
use App\Notifications\ApplicationAcceptedAfterInterview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateStatusController extends Controller
{
    /**
     * Update the application status
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected,to be interviewed,scheduled_interview',
            'action' => 'nullable|in:accept,reject',
        ]);

        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        // Track old status to check if it changed
        $oldStatus = $application->status;
        $application->status = $request->status;

        // If status is being changed to scheduled_interview, ensure there's an interview scheduled
        if ($request->status === 'scheduled_interview' && !$application->interview) {
            return redirect()->back()->with('error', 'Cannot set status to scheduled interview without an interview being scheduled.');
        }

        $application->save();

        // Send notification if status changed
        if ($oldStatus !== $application->status) {
            $application->load(['job', 'applicant']); // Make sure relations are loaded

            if ($request->action === 'accept') {
                $application->applicant->notify(new ApplicationAcceptedAfterInterview($application));
            } else {
                $application->applicant->notify(new ApplicationStatusChanged($application));
            }
        }

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}
