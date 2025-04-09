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

        // Check if all essential fields are filled
        $essentialFields = [
            'name' => $user->name,
            'email' => $user->email,
            'company_name' => $employer->company_name ?? null,
            'company_description' => $employer->company_description ?? null,
            'industry' => $employer->industry ?? null,
            'phone_number' => $employer->phone_number ?? null,
            'location' => $employer->location ?? null,
        ];

        $filledEssentials = 0;
        foreach ($essentialFields as $field => $value) {
            if (!empty($value)) {
                $filledEssentials++;
            }
        }

        // If all essential fields are filled, return 100%
        if ($filledEssentials >= count($essentialFields) - 1) {
            return 100;
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

        // Count completed optional file fields
        $completedFiles = 0;
        $totalFiles = count($optionalFileFields);

        foreach ($optionalFileFields as $field) {
            if (!empty($profile->$field) && Storage::disk('public')->exists($profile->$field)) {
                $completedFiles++;
            }
        }

        // If all required fields are complete and we have at least 70% of optional fields and files
        $isHighlyCompleted = $completedRequired == $totalRequired &&
            (($completedOptional / max(1, $totalOptional)) >= 0.7 ||
             $completedOptional == $totalOptional) &&
            (($completedFiles / max(1, $totalFiles)) >= 0.7 ||
             $completedFiles == $totalFiles);

        // If profile is highly completed, just return 100%
        if ($isHighlyCompleted) {
            return 100;
        }

        // Calculate required fields percentage (20% of total)
        $requiredPercentage = ($completedRequired / max(1, $totalRequired)) * 20;

        // Calculate optional fields percentage (50% of total)
        $optionalPercentage = ($completedOptional / max(1, $totalOptional)) * 50;

        // Calculate file percentage (30% of total)
        $filePercentage = ($completedFiles / max(1, $totalFiles)) * 30;

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

        // If all fields and files are completed, ensure it's 100%
        if ($completedRequired == $totalRequired &&
            $completedOptional == $totalOptional &&
            $completedFiles == $totalFiles) {
            $totalPercentage = 100;
        }

        // If setup is skipped with only required fields, cap at 20%
        else if ($setupCompleted && $completedRequired == $totalRequired && $completedOptional == 0 && $completedFiles == 0) {
            $totalPercentage = 20;
        }

        return $totalPercentage;
    }
}
