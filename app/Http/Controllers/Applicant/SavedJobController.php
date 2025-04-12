<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\SavedJob\IndexController;
use App\Http\Controllers\Applicant\SavedJob\SaveController;
use App\Http\Controllers\Applicant\SavedJob\UnsaveController;
use App\Models\Jobs\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    protected $indexController;
    protected $saveController;
    protected $unsaveController;

    /**
     * Constructor to inject dependencies.
     */
    public function __construct(
        IndexController $indexController,
        SaveController $saveController,
        UnsaveController $unsaveController
    ) {
        $this->indexController = $indexController;
        $this->saveController = $saveController;
        $this->unsaveController = $unsaveController;
    }

    /**
     * Display a listing of the saved jobs.
     */
    public function index(): View
    {
        return $this->indexController->__invoke();
    }

    /**
     * Save a job.
     */
    public function save(Request $request, $jobId): JsonResponse
    {
        return $this->saveController->__invoke($request, $jobId);
    }

    /**
     * Remove a job from saved jobs.
     */
    public function unsave(Request $request, $jobId): JsonResponse
    {
        return $this->unsaveController->__invoke($request, $jobId);
    }

    /**
     * Check if a job is saved by the current user.
     */
    public function isSaved($jobId): JsonResponse
    {
        $isSaved = SavedJob::where('user_id', Auth::id())
            ->where('job_id', $jobId)
            ->exists();

        return response()->json([
            'saved' => $isSaved
        ]);
    }
}
