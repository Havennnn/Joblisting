<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

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
     * Get profile completion percentage for the dashboard
     *
     * @return int
     */
    public function __invoke()
    {
        $user = Auth::user();

        // Calculate profile completion percentage
        return $this->profileCompletionService->calculateEmployerCompletion($user);
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
                'has_logo' => $employer && $employer->company_logo_path ? true : false,
                'company_id' => $employer ? $employer->company_id : null
            ]);

            // Calculate profile completion percentage
            $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion($user);

            // Determine the progress color
            $progressColor = $this->getProgressColor($completionPercentage);

            // Determine the message to display
            $message = $this->getCompletionMessage($completionPercentage, $user);

            // Determine the action link and text
            $actionData = $this->getActionLinkAndText($completionPercentage, $user);

            // Log the final result
            \Illuminate\Support\Facades\Log::info('Profile Completion Result', [
                'user_id' => $user->id,
                'percentage' => $completionPercentage,
                'color' => $progressColor,
                'message' => $message,
                'action_link' => $actionData['link'],
                'action_text' => $actionData['text']
            ]);

            return [
                'percentage' => $completionPercentage,
                'color' => $progressColor,
                'message' => $message,
                'action_link' => $actionData['link'],
                'action_text' => $actionData['text']
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
                'action_link' => route('employer.profile.index'),
                'action_text' => 'Complete Your Profile'
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
        } elseif ($percentage < 90) {
            return 'bg-yellow-500';
        } elseif ($percentage == 90) {
            return 'bg-blue-500'; // Special color for "almost complete" status
        } else {
            return 'bg-green-500';
        }
    }

    /**
     * Get the completion message based on percentage.
     *
     * @param int $percentage
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\Users\User $user
     * @return string
     */
    private function getCompletionMessage(int $percentage, $user): string
    {
        $employer = $user->employer;
        $hasCompany = !empty($employer->company_id);

        if ($hasCompany) {
            if ($percentage == 90) {
                return 'Your profile is ready to post jobs! Adding your phone number would make your profile 100% complete.';
            } elseif ($percentage == 100) {
                return 'Your company profile is complete! You\'re ready to post jobs.';
            }
        }

        if ($percentage < 30) {
            return 'Your employer profile is incomplete. Please complete your basic information.';
        } elseif ($percentage < 50) {
            return 'Your profile needs more information before you can post jobs.';
        } elseif ($percentage < 70) {
            return 'Your profile is progressing. Add more details or create/join a company to post jobs.';
        } else {
            return 'Your profile is almost there. Create or join a company to post jobs.';
        }
    }

    /**
     * Get the appropriate action link and text based on completion percentage and user profile data.
     *
     * @param int $completionPercentage
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\Users\User $user
     * @return array
     */
    private function getActionLinkAndText($completionPercentage, $user): array
    {
        $employer = $user->employer;
        $hasCompany = !empty($employer->company_id);

        if ($hasCompany) {
            if ($completionPercentage == 90) {
                return [
                    'link' => route('employer.profile.index'),
                    'text' => 'Add Phone Number'
                ];
            } elseif ($completionPercentage == 100) {
                return [
                    'link' => route('employer.jobs.create'),
                    'text' => 'Post a Job'
                ];
            }
        } else {
            // If they don't have a company
            if ($completionPercentage >= 70) {
                return [
                    'link' => route('employer.company.index'),
                    'text' => 'Create or Join a Company'
                ];
            }
        }

        // Default action for incomplete profiles
        return [
            'link' => route('employer.profile.index'),
            'text' => 'Complete Your Profile'
        ];
    }

    /**
     * Get the appropriate action link based on completion percentage and user profile data.
     *
     * @param int $completionPercentage
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\Users\User $user
     * @return string
     */
    private function getActionLink($completionPercentage, $user)
    {
        $actionData = $this->getActionLinkAndText($completionPercentage, $user);
        return $actionData['link'];
    }
}
