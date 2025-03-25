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

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $path;
        }

        // Update user profile
        $user->update($validated);
        $user->update(['setup_completed' => true]);

        return redirect()->route('applicant.dashboard')
            ->with('status', 'Profile setup completed successfully!');
    }

    /**
     * Skip the setup process
     */
    public function skip()
    {
        $user = Auth::user();
        $user->update(['setup_completed' => true]);

        return redirect()->route('applicant.dashboard')
            ->with('status', 'You can complete your profile later.');
    }
}
