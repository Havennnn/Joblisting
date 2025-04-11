<?php

namespace App\Http\Controllers\Applicant\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    /**
     * Update applicant's profile information
     *
     * Validates and updates all profile information including file uploads
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'skills' => 'required|string',
            'years_experience' => 'required|integer|min:0',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,other',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->applicantProfile && $user->applicantProfile->profile_picture_path) {
                Storage::delete($user->applicantProfile->profile_picture_path);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'local');
            $validated['profile_picture_path'] = $path;
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old resume if exists
            if ($user->applicantProfile && $user->applicantProfile->resume_path) {
                Storage::delete($user->applicantProfile->resume_path);
            }

            $path = $request->file('resume')->store('resumes', 'local');
            $validated['resume_path'] = $path;
        }

        // Update user data
        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Update or create profile
        $profile = $user->applicantProfile;
        if ($profile) {
            $profile->update([
                'full_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'phone_number' => $validated['phone_number'],
                'location' => $validated['location'],
                'field' => $validated['field'],
                'skills' => $validated['skills'],
                'years_experience' => $validated['years_experience'],
                'age' => $validated['age'],
                'gender' => $validated['gender'],
            ]);

            if (isset($validated['profile_picture_path'])) {
                $profile->profile_picture_path = $validated['profile_picture_path'];
                $profile->save();
            }

            if (isset($validated['resume_path'])) {
                $profile->resume_path = $validated['resume_path'];
                $profile->save();
            }
        } else {
            $profileData = [
                'user_id' => $user->id,
                'full_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'phone_number' => $validated['phone_number'],
                'location' => $validated['location'],
                'field' => $validated['field'],
                'skills' => $validated['skills'],
                'years_experience' => $validated['years_experience'],
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'setup_completed' => true,
            ];

            if (isset($validated['profile_picture_path'])) {
                $profileData['profile_picture_path'] = $validated['profile_picture_path'];
            }

            if (isset($validated['resume_path'])) {
                $profileData['resume_path'] = $validated['resume_path'];
            }

            $user->applicantProfile()->create($profileData);
        }

        return redirect()->route('applicant.profile')->with('status', 'Profile updated successfully!');
    }
}
