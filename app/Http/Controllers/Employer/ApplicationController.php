<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of applications for the employer's job posts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Auth::user()->employer;

        $applications = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->latest()
            ->paginate(10);

        return view('employer.applications.index', compact('applications'));
    }

    /**
     * Display the specified application
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->with(['job', 'applicant.applicantProfile'])
            ->findOrFail($id);

        // Mark as viewed if not already
        if (!$application->viewed_at) {
            $application->viewed_at = now();
            $application->save();
        }

        return view('employer.applications.show', compact('application'));
    }

    /**
     * Update the application status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $employer = Auth::user()->employer;

        $application = JobApplication::where('employer_id', $employer->id)
            ->findOrFail($id);

        // Track old status to check if it changed
        $oldStatus = $application->status;
        $application->status = $request->status;

        if ($request->has('notes')) {
            $application->notes = $request->notes;
        }

        $application->save();

        // Send notification if status changed
        if ($oldStatus !== $application->status) {
            $application->load(['job', 'applicant']); // Make sure relations are loaded
            $application->applicant->notify(new ApplicationStatusChanged($application));
        }

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}
