<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show employer's profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('employer.profile', compact('user'));
    }

    /**
     * Update employer's profile information
     *
     * Validates and updates all profile information including file uploads
     */
    public function update(Request $request)
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
                Storage::disk('public')->delete($employer->company_logo_path);
            }

            $path = $request->file('company_logo')->store('company-logos', 'public');
            $employer->company_logo_path = $path;
        }

        // Update employer profile
        $employer->fill([
            'company_name' => $validated['company_name'],
            'company_description' => $validated['company_description'],
            'industry' => $validated['industry'],
            'website' => $validated['website'] ?? null,
            'phone_number' => $validated['phone_number'],
            'location' => $validated['location'],
        ])->save();

        return redirect()->route('employer.profile')
            ->with('status', 'Company profile updated successfully!');
    }
}
