<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Validates and updates:
     * - Basic info (name, email)
     * - Professional details (headline, bio)
     * - Skills
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'headline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('applicant.profile')->with('status', 'Profile updated successfully!');
    }

    /**
     * Handle resume upload
     *
     * Accepts PDF/DOCX only.
     */
    public function uploadResume(Request $request)
    {
        // TODO: Implement resume upload
        // 1. Validate file
        // 2. Store file
        // 3. Update user's resume_path
    }
}
