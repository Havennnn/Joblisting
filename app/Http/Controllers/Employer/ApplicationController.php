<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Application\DownloadResumeController;
use App\Http\Controllers\Employer\Application\IndexController;
use App\Http\Controllers\Employer\Application\ShowController;
use App\Http\Controllers\Employer\Application\ShowJobApplicationsController;
use App\Http\Controllers\Employer\Application\UpdateStatusController;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
    protected $profileCompletionService;
    protected $indexController;
    protected $showJobApplicationsController;
    protected $showController;
    protected $updateStatusController;
    protected $downloadResumeController;

    public function __construct(
        ProfileCompletionService $profileCompletionService,
        IndexController $indexController,
        ShowJobApplicationsController $showJobApplicationsController,
        ShowController $showController,
        UpdateStatusController $updateStatusController,
        DownloadResumeController $downloadResumeController
    ) {
        $this->profileCompletionService = $profileCompletionService;
        $this->indexController = $indexController;
        $this->showJobApplicationsController = $showJobApplicationsController;
        $this->showController = $showController;
        $this->updateStatusController = $updateStatusController;
        $this->downloadResumeController = $downloadResumeController;
    }

    /**
     * Display a listing of all applications for the employer
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->indexController->__invoke();
    }

    /**
     * Display applications for a specific job
     *
     * @param int $jobId
     * @return \Illuminate\Contracts\View\View
     */
    public function showJobApplications($jobId)
    {
        return $this->showJobApplicationsController->__invoke($jobId);
    }

    /**
     * Display the specified application
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return $this->showController->__invoke($id);
    }

    /**
     * Update the application status
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        return $this->updateStatusController->__invoke($request, $id);
    }

    /**
     * Download the resume for the application
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadResume($id)
    {
        return $this->downloadResumeController->__invoke($id);
    }
}
