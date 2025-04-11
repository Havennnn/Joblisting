<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use App\Models\ApplicantProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        Log::info('Applicant Setup Step 3 Processing', [
            'user_id' => $user->id,
            'data' => $data
        ]);

        // Ensure all required data is present
        if (empty($data)) {
            Log::error('Applicant Setup: Missing setup data', [
                'user_id' => $user->id
            ]);
            return redirect()->route('applicant.setup')->withErrors(['message' => 'Setup data is missing. Please start again.']);
        }

        try {
            // Update user data
            $user->update([
                'name' => $data['full_name'],
                'email' => $data['email'],
            ]);

            // Create or update applicant profile
            $profile = ApplicantProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $data['full_name'],
                    'phone_number' => $data['phone_number'],
                    'location' => $data['location'],
                    'field' => $data['field'],
                    'skills' => $data['skills'],
                    'years_experience' => $data['years_experience'],
                    'age' => $data['age'],
                    'gender' => $data['gender'],
                    'profile_picture_path' => $data['profile_picture_path'] ?? null,
                    'resume_path' => $data['resume_path'] ?? null,
                    'setup_completed' => true
                ]
            );

            // Log successful completion
            Log::info('Applicant Setup Completed Successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id
            ]);

            // Clear session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('applicant_setup_completed', true);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('applicant.dashboard')
                ->with('status', 'Profile setup completed successfully! Thank you for registering.');
        } catch (\Exception $e) {
            Log::error('Error completing applicant setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('applicant.setup')
                ->withErrors(['error' => 'An error occurred while completing your setup: ' . $e->getMessage()]);
        }
    }
}
