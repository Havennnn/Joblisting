<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Dashboard\ProfileCompletionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * Display the employer's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $employer = $user->employer;

        \Illuminate\Support\Facades\Log::info('Employer Dashboard Accessed', [
            'user_id' => $user->id,
            'has_employer_profile' => (bool)$employer,
            'setup_completed' => $employer ? $employer->setup_completed : false
        ]);

        // If the employer hasn't completed setup, redirect to setup page
        if (!$employer || !$employer->setup_completed) {
            \Illuminate\Support\Facades\Log::info('Redirecting to setup from dashboard', [
                'user_id' => $user->id,
                'has_employer_profile' => (bool)$employer,
                'setup_completed' => $employer ? $employer->setup_completed : false
            ]);
            return redirect()->route('employer.setup');
        }

        // Get profile completion data
        $profileCompletionData = $this->profileCompletionController->getCompletionData();

        \Illuminate\Support\Facades\Log::info('Serving employer dashboard', [
            'user_id' => $user->id,
            'profile_completion' => $profileCompletionData['percentage']
        ]);

        return view('employer.dashboard', [
            'user' => $user,
            'employer' => $employer,
            'profileCompletionPercentage' => $profileCompletionData['percentage'],
            'profileCompletionColor' => $profileCompletionData['color'],
            'profileCompletionMessage' => $profileCompletionData['message'],
            'profileActionLink' => $profileCompletionData['action_link'],
        ]);
    }

    /**
     * Display the employer profile edit page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('employer.profile');
    }
}
