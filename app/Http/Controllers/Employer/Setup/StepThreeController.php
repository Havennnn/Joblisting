<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StepThreeController extends Controller
{
    /**
     * Process step 3 (Confirm and Save)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $data = Session::get('setup_data', []);

        // Add debug logging
        Log::info('Employer Setup Step 3 Processing', [
            'user_id' => $user->id,
            'data' => $data
        ]);

        // Ensure all required data is present
        if (empty($data)) {
            Log::error('Employer Setup: Missing setup data', [
                'user_id' => $user->id
            ]);
            return redirect()->route('employer.setup')->withErrors(['message' => 'Setup data is missing. Please start again.']);
        }

        try {
            // Ensure employer profile exists
            $employer = $user->employer ?? $user->employer()->create([]);

            // Debug employer profile before update
            Log::info('Employer profile before update', [
                'employer_id' => $employer->id,
                'current_phone' => $employer->phone_number,
                'current_industry' => $employer->industry,
                'form_phone' => $data['phone_number'] ?? 'not provided',
                'form_industry' => $data['industry'] ?? 'not provided'
            ]);

            // Update user data
            $user->update([
                'name' => $data['full_name'],
                'email' => $data['email'],
            ]);

            // Update employer profile with all fields including phone_number and location
            // Remove any fields that are not in the employers table to avoid SQL errors
            $profileData = [
                'company_name' => $data['company_name'],
                'company_description' => $data['company_description'],
                'industry' => $data['industry'] ?? null,
                'website' => $data['website'] ?? null,
                'phone_number' => $data['phone_number'],
                'location' => $data['location'] ?? null,
                'setup_completed' => true
            ];

            // Handle company logo if present in session data
            if (!empty($data['company_logo_path'])) {
                $profileData['company_logo_path'] = $data['company_logo_path'];

                // Verify logo exists in storage
                Log::info('Company logo path check', [
                    'logo_path' => $data['company_logo_path'],
                    'exists' => Storage::disk('public')->exists($data['company_logo_path']),
                    'full_url' => asset('storage/' . $data['company_logo_path'])
                ]);
            }

            // Update employer profile
            $employer->fill($profileData)->save();

            // Debug employer profile after update
            Log::info('Employer profile after update', [
                'employer_id' => $employer->id,
                'updated_phone' => $employer->phone_number,
                'updated_industry' => $employer->industry,
                'updated_location' => $employer->location,
                'all_fields' => $profileData
            ]);

            // Clear session data before redirecting
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('employer_setup_completed', true);

            Log::info('Employer Setup Completed Successfully', [
                'user_id' => $user->id,
                'employer_id' => $employer->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('employer.dashboard')
                ->with('status', 'Company profile setup completed successfully! Thank you for registering.');

        } catch (\Exception $e) {
            Log::error('Error completing employer setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.setup')
                ->withErrors(['error' => 'An error occurred while completing your setup: ' . $e->getMessage()]);
        }
    }
}
