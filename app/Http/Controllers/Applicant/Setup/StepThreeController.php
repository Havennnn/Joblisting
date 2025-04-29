<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\ApplicantProfile;
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
        $userId = Auth::id();
        $user = User::find($userId);
        $data = Session::get('setup_data', []);

        // Add debug logging
        Log::info('Applicant Setup Step 3 Processing', [
            'user_id' => $userId,
            'data' => $data
        ]);

        // Ensure all required data is present
        if (empty($data)) {
            Log::error('Applicant Setup: Missing setup data', [
                'user_id' => $userId
            ]);
            return redirect()->route('applicant.setup')->withErrors(['message' => 'Setup data is missing. Please start again.']);
        }

        try {
            // Update user data
            $user->name = $data['full_name'];
            $user->email = $data['email'];
            $user->save();

            // Create or update applicant profile
            $profile = ApplicantProfile::where('user_id', $userId)->first();
            if (!$profile) {
                $profile = new ApplicantProfile();
                $profile->user_id = $userId;
            }

            $profile->full_name = $data['full_name'];
            $profile->phone_number = $data['phone_number'];
            $profile->location = $data['location'];
            $profile->field = $data['field'];
            $profile->skills = $data['skills'];
            $profile->years_experience = $data['years_experience'];
            $profile->age = $data['age'];
            $profile->gender = $data['gender'];
            $profile->profile_picture_path = $data['profile_picture_path'] ?? null;
            $profile->resume_path = $data['resume_path'] ?? null;
            $profile->setup_completed = true;
            $profile->save();

            // Log successful completion
            Log::info('Applicant Setup Completed Successfully', [
                'user_id' => $userId,
                'profile_id' => $profile->id
            ]);

            // Clear session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user data to ensure middleware sees the changes
            $user = User::find($userId); // Re-fetch user with fresh data

            // Store successful setup flag in session to bypass middleware check
            Session::put('applicant_setup_completed', true);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('applicant.dashboard')
                ->with('status', 'Profile setup completed successfully! Thank you for registering.');
        } catch (\Exception $e) {
            Log::error('Error completing applicant setup', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('applicant.setup')
                ->withErrors(['error' => 'An error occurred while completing your setup: ' . $e->getMessage()]);
        }
    }
}
