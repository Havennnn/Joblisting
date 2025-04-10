<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show employer's profile view page
     */
    public function show()
    {
        return view('employer.profile-view');
    }

    /**
     * Show employer's profile edit page
     */
    public function edit()
    {
        return view('employer.profile-edit');
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

        return redirect()->route('employer.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Securely serve company logo from private storage
     */
    public function showCompanyLogo(User $user)
    {
        // Security check - only allow viewing own company logo, the logo's company, or admin access
        if (Auth::id() !== $user->id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        // Check if user is an employer and has a company logo
        if (!$user->isEmployer() || !$user->employer || !$user->employer->company_logo_path) {
            abort(404, 'Company logo not found');
        }

        // Get the company logo path
        $path = $user->employer->company_logo_path;

        // Check if file exists
        if (!Storage::exists($path)) {
            abort(404, 'Company logo not found');
        }

        // Return the file
        $file = Storage::get($path);
        $mimeType = Storage::mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType);
    }
}
