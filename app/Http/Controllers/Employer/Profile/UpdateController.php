<?php

namespace App\Http\Controllers\Employer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    /**
     * Update employer's profile information
     *
     * Validates and updates all profile information including file uploads
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $employer = $user->employer;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Update user data
        $user->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
        ]);

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old company logo if exists
            if ($employer->company_logo_path) {
                Storage::delete($employer->company_logo_path);
            }

            // Store in private storage (local disk) instead of public
            $path = $request->file('company_logo')->store('company-logos', 'local');
            $employer->company_logo_path = $path;
        }

        // Update employer data
        $employer->update([
            'full_name' => $validated['full_name'],
            'company_name' => $validated['company_name'],
            'company_description' => $validated['company_description'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'phone_number' => $validated['phone_number'],
            'location' => $validated['location'],
        ]);

        return redirect()->route('employer.profile.index')
            ->with('success', 'Profile updated successfully.');
    }
}
