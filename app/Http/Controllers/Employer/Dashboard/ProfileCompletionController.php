<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Support\Facades\Auth;

class ProfileCompletionController extends Controller
{
    /**
     * @var ProfileCompletionService
     */
    protected $profileCompletionService;

    /**
     * Constructor.
     *
     * @param ProfileCompletionService $profileCompletionService
     */
    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Get the profile completion data for the dashboard.
     *
     * @return array
     */
    public function getCompletionData()
    {
        try {
            $user = Auth::user();
            $employer = $user->employer;

            // Log employer profile data
            \Illuminate\Support\Facades\Log::info('Employer Profile Data', [
                'user_id' => $user->id,
                'employer_id' => $employer ? $employer->id : null,
                'industry' => $employer ? $employer->industry : null,
                'phone_number' => $employer ? $employer->phone_number : null,
                'location' => $employer ? $employer->location : null,
                'company_name' => $employer ? $employer->company_name : null,
                'has_logo' => $employer && $employer->company_logo_path ? true : false
            ]);

            // Calculate profile completion percentage
            $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion($user);

            // Determine the progress color
            $progressColor = $this->getProgressColor($completionPercentage);

            // Determine the message to display
            $message = $this->getCompletionMessage($completionPercentage, $user);

            // Determine the action link
            $actionLink = $this->getActionLink($completionPercentage, $user);

            // Log the final result
            \Illuminate\Support\Facades\Log::info('Profile Completion Result', [
                'user_id' => $user->id,
                'percentage' => $completionPercentage,
                'color' => $progressColor,
                'message' => $message
            ]);

            return [
                'percentage' => $completionPercentage,
                'color' => $progressColor,
                'message' => $message,
                'action_link' => $actionLink
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error calculating profile completion', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return default values in case of error
            return [
                'percentage' => 0,
                'color' => 'bg-red-500',
                'message' => 'We could not calculate your profile completion. Please check your profile.',
                'action_link' => route('employer.profile')
            ];
        }
    }

    /**
     * Get the progress color based on completion percentage.
     *
     * @param int $percentage
     * @return string
     */
    private function getProgressColor(int $percentage): string
    {
        if ($percentage < 50) {
            return 'bg-red-500';
        } elseif ($percentage < 100) {
            return 'bg-yellow-500';
        } else {
            return 'bg-green-500';
        }
    }

    /**
     * Get the completion message based on percentage.
     *
     * @param int $percentage
     * @param mixed $user
     * @return string
     */
    private function getCompletionMessage(int $percentage, $user): string
    {
        if ($percentage < 50) {
            return 'Your company profile is incomplete. Complete it to attract more applicants.';
        } elseif ($percentage < 100) {
            return 'Your company profile is partially complete. Add more details to attract qualified candidates.';
        } else {
            return 'Your company profile is complete! You\'re ready to post jobs.';
        }
    }

    /**
     * Get the action link based on completion status.
     *
     * @param int $percentage
     * @param mixed $user
     * @return string
     */
    private function getActionLink(int $percentage, $user): string
    {
        if ($percentage < 100) {
            return route('employer.profile');
        } else {
            return route('employer.profile');
        }
    }
}
