<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use App\Models\Jobs\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobsController extends Controller
{
    /**
     * Display a listing of saved jobs.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $savedJobs = SavedJob::where('applicant_id', $user->id)
            ->with(['job.employer'])
            ->latest()
            ->paginate(10);

        return view('applicant.saved-jobs.index', compact('savedJobs'));
    }

    /**
     * Toggle a job as saved/unsaved
     */
    public function toggle(Request $request, $jobId)
    {
        try {
            $user = Auth::user();

            // Check if the job is already saved
            $existingSave = SavedJob::where('applicant_id', $user->id)
                ->where('job_id', $jobId)
                ->first();

            if ($existingSave) {
                // If already saved, unsave it
                $existingSave->delete();
                return response()->json([
                    'status' => 'success',
                    'action' => 'unsaved',
                    'message' => 'Job removed from saved jobs'
                ]);
            } else {
                // If not saved, save it
                SavedJob::create([
                    'applicant_id' => $user->id,
                    'job_id' => $jobId
                ]);

                return response()->json([
                    'status' => 'success',
                    'action' => 'saved',
                    'message' => 'Job saved successfully'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
