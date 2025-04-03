<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\ApplicantProfile;

class SetupController extends Controller
{
    /**
     * Show the setup wizard based on current step
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $step = Session::get('setup_step', 1);
        $data = Session::get('setup_data', []);

        return view('applicant.setup', compact('user', 'step', 'data'));
    }

    /**
     * Process step 1 (Basic Information)
     */
    public function processStepOne(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer|min:18',
        ]);

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 2);

        return redirect()->route('applicant.setup');
    }

    /**
     * Process step 2 (Professional Information)
     */
    public function processStepTwo(Request $request)
    {
        $validated = $request->validate([
            'field' => 'required|string|max:255',
            'skills' => 'required|string',
            'years_experience' => 'required|integer|min:0',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Remove file objects from validated data to prevent serialization issues
        if (isset($validated['profile_picture'])) {
            unset($validated['profile_picture']);
        }
        if (isset($validated['resume'])) {
            unset($validated['resume']);
        }

        // Process profile picture if uploaded
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture_path'] = $path;
        }

        // Process resume if uploaded
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $path;
        }

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 3);

        return redirect()->route('applicant.setup');
    }

    /**
     * Process step 3 (Confirm and Save)
     */
    public function processStepThree(Request $request)
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

    /**
     * Skip the setup process
     */
    public function skip(Request $request)
    {
        $user = Auth::user();
        $profile = $user->applicantProfile;

        Log::info('Applicant Setup Skip Requested', [
            'user_id' => $user->id
        ]);

        try {
            if ($profile) {
                $profile->update(['setup_completed' => true]);
            } else {
                // Create a basic profile if it doesn't exist
                $profile = ApplicantProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'full_name' => $user->name,
                        'setup_completed' => true
                    ]
                );
            }

            // Clear any existing session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to update middleware checks
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('applicant_setup_completed', true);

            Log::info('Applicant Setup Skipped Successfully', [
                'user_id' => $user->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('applicant.dashboard')
                ->with('status', 'You can complete your profile later.');
        } catch (\Exception $e) {
            Log::error('Error skipping applicant setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('applicant.setup')
                ->withErrors(['error' => 'An error occurred while skipping setup: ' . $e->getMessage()]);
        }
    }

    /**
     * Go back to previous step
     */
    public function previous(Request $request)
    {
        $currentStep = Session::get('setup_step', 1);

        if ($currentStep > 1) {
            Session::put('setup_step', $currentStep - 1);
        }

        return redirect()->route('applicant.setup');
    }
}
