<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the applicant's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Calculate profile completion percentage
        $profileCompletionPercentage = $this->calculateProfileCompletion($user);

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
            'profileCompletionPercentage' => $profileCompletionPercentage,
        ]);
    }

    /**
     * Calculate the profile completion percentage.
     *
     * @param \App\Models\User $user
     * @return int
     */
    private function calculateProfileCompletion($user)
    {
        // Required fields for basic profile
        $requiredFields = [
            'name',
            'email'
        ];

        // Optional fields that contribute to profile completion
        $optionalFields = [
            'phone_number',
            'gender',
            'age',
            'field',
            'skills',
            'years_experience'
        ];

        // Optional file fields that enhance completion but aren't required
        $optionalFileFields = [
            'profile_picture_path',
            'resume_path'
        ];

        // Count completed required fields
        $completedRequired = 0;
        $totalRequired = count($requiredFields);

        foreach ($requiredFields as $field) {
            if (!empty($user->$field)) {
                $completedRequired++;
            }
        }

        // Calculate required fields percentage (50% of total)
        $requiredPercentage = ($completedRequired / $totalRequired) * 50;

        // Count completed optional fields
        $completedOptional = 0;
        $totalOptional = count($optionalFields);

        foreach ($optionalFields as $field) {
            if (!empty($user->$field)) {
                $completedOptional++;
            }
        }

        // Calculate optional fields percentage (30% of total)
        $optionalPercentage = $totalOptional > 0 ? ($completedOptional / $totalOptional) * 30 : 0;

        // Count completed optional file fields
        $completedFiles = 0;
        $totalFiles = count($optionalFileFields);

        foreach ($optionalFileFields as $field) {
            if (!empty($user->$field) && Storage::disk('public')->exists($user->$field)) {
                $completedFiles++;
            }
        }

        // Calculate file percentage (20% of total)
        $filePercentage = $totalFiles > 0 ? ($completedFiles / $totalFiles) * 20 : 0;

        // Combine percentages
        $totalPercentage = round($requiredPercentage + $optionalPercentage + $filePercentage);

        // Ensure minimum 50% if setup is completed and all required fields are filled
        if ($user->setup_completed && $completedRequired == $totalRequired) {
            $totalPercentage = max($totalPercentage, 50);
        }

        return $totalPercentage;
    }
}
