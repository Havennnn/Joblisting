<?php

namespace App\Http\Controllers\Applicant\SavedJob;

use App\Http\Controllers\Controller;
use App\Models\Jobs\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SaveController extends Controller
{
    /**
     * Save a job for the current user.
     *
     * @param Request $request
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, int $jobId): JsonResponse
    {
        try {
            // Create or update the saved job record
            SavedJob::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'job_id' => $jobId
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Job saved successfully.',
                'saved' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save job: ' . $e->getMessage()
            ], 500);
        }
    }
}
