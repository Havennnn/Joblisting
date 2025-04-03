<?php

namespace App\Http\Controllers\Applicant\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

            // Log user information
            Log::info('Calculating Applicant Profile Completion', [
                'user_id' => $user->id,
                'has_profile' => $user->applicantProfile ? true : false
            ]);

            // Calculate profile completion percentage
            $completionPercentage = $this->profileCompletionService->calculateApplicantCompletion($user);

            // Determine the progress color
            $progressColor = $this->getProgressColor($completionPercentage);

            // Determine the message to display
            $message = $this->getCompletionMessage($completionPercentage, $user);

            // Determine the action link
            $actionLink = $this->getActionLink($completionPercentage, $user);

            // Log the final result
            Log::info('Applicant Profile Completion Result', [
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
            Log::error('Error calculating applicant profile completion', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return default values in case of error
            return [
                'percentage' => 0,
                'color' => 'bg-yellow-500',
                'message' => 'We could not calculate your profile completion. Please check your profile.',
                'action_link' => route('applicant.profile')
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
            return 'Your profile is incomplete. Complete it to increase your visibility to employers.';
        } elseif ($percentage < 100) {
            return 'Your profile is partially complete. Add more details to stand out to employers.';
        } else {
            return 'Your profile is complete! You\'re ready to apply for jobs.';
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
            if ($user->applicantProfile && $user->applicantProfile->setup_completed) {
                return route('applicant.profile');
            } else {
                return route('applicant.setup');
            }
        } else {
            return route('applicant.profile');
        }
    }
}
