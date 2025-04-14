<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Dashboard\ProfileCompletionController;
use App\Models\Jobs\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        try {
            // Get profile completion data
            $profileCompletionData = $this->profileCompletionController->getCompletionData();

            // Log the data we're passing to the view
            Log::info('Dashboard data for applicant', [
                'user_id' => $user->id,
                'profile_completion' => $profileCompletionData['percentage']
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting profile completion data', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            // Default values if there's an error
            $profileCompletionData = [
                'percentage' => 0,
                'color' => 'bg-yellow-500',
                'message' => 'Your profile setup is complete. You can further enhance your profile in the profile section.',
                'action_link' => route('applicant.profile'),
            ];
        }

        // Fetch the user's recent applications
        $applications = JobApplication::where('applicant_id', $user->id)
            ->with('job.employer')
            ->latest()
            ->take(5)
            ->get();

        return view('applicant.dashboard', [
            'user' => $user,
            'applications' => $applications,
            'profileCompletionPercentage' => $profileCompletionData['percentage'],
            'profileCompletionColor' => $profileCompletionData['color'],
            'profileCompletionMessage' => $profileCompletionData['message'],
            'profileActionLink' => $profileCompletionData['action_link'],
        ]);
    }
}
