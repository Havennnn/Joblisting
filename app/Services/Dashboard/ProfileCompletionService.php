<?php

namespace App\Services\Dashboard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'industry',
            'phone_number',
            'location',
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
        // Debug the profile fields
        Log::info('Profile Completion Data', [
            'profile_type' => get_class($profile),
            'profile_id' => $profile->id,
            'industry' => $profile->industry ?? 'not set',
            'phone_number' => $profile->phone_number ?? 'not set',
            'location' => $profile->location ?? 'not set'
        ]);

        // Count completed required fields
        $completedRequired = 0;
        $totalRequired = count($requiredFields);

        foreach ($requiredFields as $field => $value) {
            if (!empty($value)) {
                $completedRequired++;
            }
        }

        // Calculate required fields percentage (20% of total instead of 50%)
        // This reduces the weight of just having name and email
        $requiredPercentage = ($completedRequired / $totalRequired) * 20;

        // Count completed optional fields
        $completedOptional = 0;
        $totalOptional = count($optionalFields);
        $completedFields = [];
        $emptyFields = [];

        foreach ($optionalFields as $field) {
            if (isset($profile->$field) && ($profile->$field === 0 || $profile->$field === '0' || !empty($profile->$field))) {
                $completedOptional++;
                $completedFields[] = $field;
            } else {
                $emptyFields[] = $field;
            }
        }

        // Log completed and empty fields
        Log::info('Optional Fields Analysis', [
            'profile_id' => $profile->id,
            'completed_fields' => $completedFields,
            'empty_fields' => $emptyFields,
            'completed_count' => $completedOptional,
            'total_optional' => $totalOptional
        ]);

        // Calculate optional fields percentage (50% of total instead of 30%)
        // This increases the importance of filling out profile details
        $optionalPercentage = $totalOptional > 0 ? ($completedOptional / $totalOptional) * 50 : 0;

        // Count completed optional file fields
        $completedFiles = 0;
        $totalFiles = count($optionalFileFields);

        foreach ($optionalFileFields as $field) {
            if (!empty($profile->$field) && Storage::disk('public')->exists($profile->$field)) {
                $completedFiles++;
            }
        }

        // Calculate file percentage (30% of total instead of 20%)
        // This increases the importance of uploading profile picture and resume
        $filePercentage = $totalFiles > 0 ? ($completedFiles / $totalFiles) * 30 : 0;

        // Combine percentages
        $totalPercentage = round($requiredPercentage + $optionalPercentage + $filePercentage);

        // Log final calculation
        Log::info('Profile Completion Result', [
            'profile_id' => $profile->id,
            'required_percentage' => $requiredPercentage,
            'optional_percentage' => $optionalPercentage,
            'file_percentage' => $filePercentage,
            'total_percentage' => $totalPercentage
        ]);

        // If setup is skipped with only required fields, cap at 20% instead of 50%
        if ($setupCompleted && $completedRequired == $totalRequired && $completedOptional == 0 && $completedFiles == 0) {
            $totalPercentage = 20;
        }

        return $totalPercentage;
    }
}
