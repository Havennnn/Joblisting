<?php

namespace App\Http\Controllers\Applicant\SavedJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UnsaveController extends Controller
{
    /**
     * Remove a saved job for the current user.
     *
     * @param Request $request
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, int $jobId): JsonResponse
    {
        try {
            // Delete the saved job record
            SavedJob::where('user_id', Auth::id())
                ->where('job_id', $jobId)
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Job removed from saved jobs.',
                'saved' => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove saved job: ' . $e->getMessage()
            ], 500);
        }
    }
}
