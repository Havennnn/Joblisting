<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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

        return view('employer.setup', compact('user', 'step', 'data'));
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
        ]);

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 2);

        return redirect()->route('employer.setup');
    }

    /**
     * Process step 2 (Company Information)
     */
    public function processStepTwo(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Remove 'company_logo' from validated array since we can't store the file object in session
        if (isset($validated['company_logo'])) {
            unset($validated['company_logo']);
        }

        // Process company logo if uploaded
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $path = $file->store('company-logos', 'public');

            // Verify the file was stored successfully
            if (Storage::disk('public')->exists($path)) {
                // Log logo upload success to help with debugging
                Log::info('Company logo uploaded', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'stored_path' => $path,
                    'exists_in_storage' => Storage::disk('public')->exists($path),
                    'full_url' => asset('storage/' . $path)
                ]);

                $validated['company_logo_path'] = $path;
            } else {
                Log::error('Failed to store company logo', [
                    'original_name' => $file->getClientOriginalName()
                ]);
            }
        }

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 3);

        return redirect()->route('employer.setup');
    }

    /**
     * Process step 3 (Confirm and Save)
     */
    public function processStepThree(Request $request)
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

    /**
     * Skip the setup process
     */
    public function skip(Request $request)
    {
        $user = Auth::user();
        $employer = $user->employer;

        Log::info('Employer Setup Skip Requested', [
            'user_id' => $user->id
        ]);

        try {
            if ($employer) {
                $employer->update(['setup_completed' => true]);
            } else {
                // Create a basic profile if it doesn't exist
                $user->employer()->create([
                    'company_name' => $user->name . "'s Company",
                    'setup_completed' => true
                ]);
            }

            // Clear any existing session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('employer_setup_completed', true);

            Log::info('Employer Setup Skipped Successfully', [
                'user_id' => $user->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('employer.dashboard')
                ->with('status', 'You can complete your company profile later.');

        } catch (\Exception $e) {
            Log::error('Error skipping employer setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.setup')
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

        return redirect()->route('employer.setup');
    }
}
