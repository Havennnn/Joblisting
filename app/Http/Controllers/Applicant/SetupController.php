<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SetupController extends Controller
{
    /**
     * Show the setup wizard
     */
    public function index()
    {
        $user = Auth::user();
        return view('applicant.setup', compact('user'));
    }

    /**
     * Store the setup information
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $profile = $user->applicantProfile;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'field' => 'required|string|max:255',
            'skills' => 'required|string',
            'years_experience' => 'required|integer|min:0',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,other',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Update user data
        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $profile->profile_picture_path = $path;
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $profile->resume_path = $path;
        }

        // Update applicant profile
        $profile->update([
            'full_name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'field' => $validated['field'],
            'skills' => $validated['skills'],
            'years_experience' => $validated['years_experience'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'setup_completed' => true
        ]);

        return redirect()->route('applicant.dashboard')
            ->with('status', 'Profile setup completed successfully!');
    }

    /**
     * Skip the setup process
     */
    public function skip()
    {
        $user = Auth::user();
        $profile = $user->applicantProfile;

        if ($profile) {
            $profile->update(['setup_completed' => true]);
        } else {
            // Create a basic profile if it doesn't exist
            $user->applicantProfile()->create([
                'full_name' => $user->name,
                'setup_completed' => true
            ]);
        }

        return redirect()->route('applicant.dashboard')
            ->with('status', 'You can complete your profile later.');
    }
}
