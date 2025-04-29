<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StepTwoController extends Controller
{
    /**
     * Process step 2 (Professional Information)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
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
}
