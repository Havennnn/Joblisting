<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ProfileCompletionService;
use App\Http\Controllers\Employer\Dashboard\ActiveJobPostsController;
use App\Http\Controllers\Employer\Dashboard\ApplicationStatsController;
use App\Http\Controllers\Employer\Dashboard\RecentApplicationsController;
use App\Http\Controllers\Employer\ProfileCompletionController;

class DashboardController extends Controller
{
    protected $profileCompletionService;
    protected $activeJobPostsController;
    protected $applicationStatsController;
    protected $recentApplicationsController;
    protected $profileCompletionController;

    public function __construct(
        ProfileCompletionService $profileCompletionService,
        ActiveJobPostsController $activeJobPostsController,
        ApplicationStatsController $applicationStatsController,
        RecentApplicationsController $recentApplicationsController,
        ProfileCompletionController $profileCompletionController
    ) {
        $this->profileCompletionService = $profileCompletionService;
        $this->activeJobPostsController = $activeJobPostsController;
        $this->applicationStatsController = $applicationStatsController;
        $this->recentApplicationsController = $recentApplicationsController;
        $this->profileCompletionController = $profileCompletionController;
    }

    public function index()
    {
        // Get active job posts count
        $activeJobPosts = $this->activeJobPostsController->__invoke();

        // Get application statistics
        $applicationStats = $this->applicationStatsController->__invoke();

        // Get recent applications
        $recentApplications = $this->recentApplicationsController->__invoke();

        // Get profile completion percentage
        $profileCompletion = $this->profileCompletionController->__invoke();

        // Extract application stats
        $totalApplications = $applicationStats['totalApplications'];
        $newApplications = $applicationStats['newApplications'];
        $pendingApplications = $applicationStats['pendingApplications'];
        $reviewingApplications = $applicationStats['reviewingApplications'];
        $acceptedApplications = $applicationStats['acceptedApplications'];

        return view('employer.dashboard', compact(
            'activeJobPosts',
            'totalApplications',
            'newApplications',
            'pendingApplications',
            'reviewingApplications',
            'acceptedApplications',
            'recentApplications',
            'profileCompletion'
        ));
    }
}
