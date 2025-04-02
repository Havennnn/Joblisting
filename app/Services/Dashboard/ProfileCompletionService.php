<?php

namespace App\Services\Dashboard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;

class ProfileCompletionService
{
    /**
     * Calculate the applicant profile completion percentage.
     *
     * @param Authenticatable|null $user
     * @return int
     */
    public function calculateApplicantCompletion(?Authenticatable $user): int
    {
        // Return 0 if user is null
        if (!$user) {
            return 0;
        }

        // Get the applicant profile
        $profile = $user->applicantProfile;

        // Return 0 if profile doesn't exist
        if (!$profile) {
            return 0;
        }

        // Required fields for basic profile
        $requiredFields = [
            'name' => $user->name,
            'email' => $user->email
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

        return $this->calculateCompletion(
            $requiredFields,
            $optionalFields,
            $optionalFileFields,
            $profile,
            $profile->setup_completed
        );
    }

    /**
     * Calculate the employer profile completion percentage.
     *
     * @param Authenticatable|null $user
     * @return int
     */
    public function calculateEmployerCompletion(?Authenticatable $user): int
    {
        // Return 0 if user is null
        if (!$user) {
            return 0;
        }

        $employer = $user->employer;

        // Return 0 if employer record doesn't exist
        if (!$employer) {
            return 0;
        }

        // Required fields for basic profile
        $requiredFields = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        // Optional fields that contribute to profile completion
        $optionalFields = [
            'company_name',
            'company_description',
            'website',
        ];

        // Optional file fields
        $optionalFileFields = [
            'company_logo_path',
        ];

        return $this->calculateCompletion(
            $requiredFields,
            $optionalFields,
            $optionalFileFields,
            $employer,
            $employer->setup_completed
        );
    }

    /**
     * Generic profile completion calculation method.
     *
     * @param array $requiredFields
     * @param array $optionalFields
     * @param array $optionalFileFields
     * @param mixed $profile
     * @param bool $setupCompleted
     * @return int
     */
    private function calculateCompletion(
        array $requiredFields,
        array $optionalFields,
        array $optionalFileFields,
        $profile,
        bool $setupCompleted
    ): int {
        // Count completed required fields
        $completedRequired = 0;
        $totalRequired = count($requiredFields);

        foreach ($requiredFields as $field => $value) {
            if (!empty($value)) {
                $completedRequired++;
            }
        }

        // Calculate required fields percentage (50% of total)
        $requiredPercentage = ($completedRequired / $totalRequired) * 50;

        // Count completed optional fields
        $completedOptional = 0;
        $totalOptional = count($optionalFields);

        foreach ($optionalFields as $field) {
            if (!empty($profile->$field)) {
                $completedOptional++;
            }
        }

        // Calculate optional fields percentage (30% of total)
        $optionalPercentage = $totalOptional > 0 ? ($completedOptional / $totalOptional) * 30 : 0;

        // Count completed optional file fields
        $completedFiles = 0;
        $totalFiles = count($optionalFileFields);

        foreach ($optionalFileFields as $field) {
            if (!empty($profile->$field) && Storage::disk('public')->exists($profile->$field)) {
                $completedFiles++;
            }
        }

        // Calculate file percentage (20% of total)
        $filePercentage = $totalFiles > 0 ? ($completedFiles / $totalFiles) * 20 : 0;

        // Combine percentages
        $totalPercentage = round($requiredPercentage + $optionalPercentage + $filePercentage);

        // Ensure minimum 50% if setup is completed and all required fields are filled
        if ($setupCompleted && $completedRequired == $totalRequired) {
            $totalPercentage = max($totalPercentage, 50);
        }

        return $totalPercentage;
    }
}
