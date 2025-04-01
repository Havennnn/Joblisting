<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show applicant's profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('applicant.profile', compact('user'));
    }

    /**
     * Update applicant's profile information
     *
     * Validates and updates all profile information including file uploads
     */
    public function update(Request $request)
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
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old resume if exists
            if ($user->resume_path) {
                Storage::disk('public')->delete($user->resume_path);
            }

            $path = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $path;
        }

        // Update user profile
        $user->update($validated);

        return redirect()->route('applicant.profile')->with('status', 'Profile updated successfully!');
    }
}
