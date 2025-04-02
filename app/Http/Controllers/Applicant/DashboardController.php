<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Dashboard\ProfileCompletionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardController extends Controller
{
    /**
     * @var ProfileCompletionController
     */
    protected $profileCompletionController;

    /**
     * Constructor.
     *
     * @param ProfileCompletionController $profileCompletionController
     */
    public function __construct(ProfileCompletionController $profileCompletionController)
    {
        $this->profileCompletionController = $profileCompletionController;
    }

    /**
     * Display the applicant's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get profile completion data
        $profileCompletionData = $this->profileCompletionController->getCompletionData();

        // Sample data - in a real application, you'd retrieve this from your database
        $recentJobs = [
            // Sample jobs
        ];

        $applications = [
            // Sample applications
        ];

        return view('applicant.dashboard', [
            'user' => $user,
            'recentJobs' => $recentJobs,
            'applications' => $applications,
            'profileCompletionPercentage' => $profileCompletionData['percentage'],
            'profileCompletionColor' => $profileCompletionData['color'],
            'profileCompletionMessage' => $profileCompletionData['message'],
            'profileActionLink' => $profileCompletionData['action_link'],
        ]);
    }
}
