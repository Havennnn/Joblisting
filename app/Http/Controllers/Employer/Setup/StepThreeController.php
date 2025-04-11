<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\Employer;
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
        $userId = Auth::id();
        $user = User::find($userId);
        $data = Session::get('setup_data', []);

        // Add debug logging
        Log::info('Employer Setup Step 3 Processing', [
            'user_id' => $userId,
            'data' => $data
        ]);

        // Ensure all required data is present
        if (empty($data)) {
            Log::error('Employer Setup: Missing setup data', [
                'user_id' => $userId
            ]);
            return redirect()->route('employer.setup')->withErrors(['message' => 'Setup data is missing. Please start again.']);
        }

        try {
            // Ensure employer profile exists
            $employer = Employer::where('user_id', $userId)->first();
            if (!$employer) {
                $employer = Employer::create(['user_id' => $userId]);
            }

            // Debug employer profile before update
            Log::info('Employer profile before update', [
                'employer_id' => $employer->id,
                'current_phone' => $employer->phone_number,
                'current_industry' => $employer->industry,
                'form_phone' => $data['phone_number'] ?? 'not provided',
                'form_industry' => $data['industry'] ?? 'not provided'
            ]);

            // Update user data
            $user->name = $data['full_name'];
            $user->email = $data['email'];
            $user->save();

            // Update employer profile with all fields including phone_number and location
            $employer->company_name = $data['company_name'];
            $employer->company_description = $data['company_description'];
            $employer->industry = $data['industry'] ?? null;
            $employer->website = $data['website'] ?? null;
            $employer->phone_number = $data['phone_number'];
            $employer->location = $data['location'] ?? null;
            $employer->setup_completed = true;

            // Handle company logo if present in session data
            if (!empty($data['company_logo_path'])) {
                $employer->company_logo_path = $data['company_logo_path'];

                // Verify logo exists in storage
                Log::info('Company logo path check', [
                    'logo_path' => $data['company_logo_path'],
                    'exists' => Storage::disk('public')->exists($data['company_logo_path']),
                    'full_url' => asset('storage/' . $data['company_logo_path'])
                ]);
            }

            // Save employer profile
            $employer->save();

            // Debug employer profile after update
            Log::info('Employer profile after update', [
                'employer_id' => $employer->id,
                'updated_phone' => $employer->phone_number,
                'updated_industry' => $employer->industry,
                'updated_location' => $employer->location
            ]);

            // Clear session data before redirecting
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload user data to ensure middleware sees the changes
            $user = User::find($userId);

            // Store successful setup flag in session to bypass middleware check
            Session::put('employer_setup_completed', true);

            Log::info('Employer Setup Completed Successfully', [
                'user_id' => $userId,
                'employer_id' => $employer->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('employer.dashboard')
                ->with('status', 'Company profile setup completed successfully! Thank you for registering.');

        } catch (\Exception $e) {
            Log::error('Error completing employer setup', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.setup')
                ->withErrors(['error' => 'An error occurred while completing your setup: ' . $e->getMessage()]);
        }
    }
}
