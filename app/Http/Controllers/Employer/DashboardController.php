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

        // If the employer hasn't completed setup, redirect to setup page
        if (!$employer || !$employer->setup_completed) {
            return redirect()->route('employer.setup');
        }

        // Get profile completion data
        $profileCompletionData = $this->profileCompletionController->getCompletionData();

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
     * Display the employer profile setup page.
     *
     * @return \Illuminate\View\View
     */
    public function setup()
    {
        return view('employer.setup');
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
