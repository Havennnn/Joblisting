<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileSetup extends Component
{
    use WithFileUploads;

    // User data properties
    public $full_name;
    public $email;

    // Company data properties
    public $company_name;
    public $company_description;
    public $website;

    // File upload properties
    public $company_logo;
    public $company_logo_preview;

    // User model instance
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $employer = $this->user->employer;

        // If user has existing data, populate the form fields
        if ($employer) {
            $this->full_name = $employer->full_name ?? $this->user->name;
            $this->email = $this->user->email;
            $this->company_name = $employer->company_name;
            $this->company_description = $employer->company_description;
            $this->website = $employer->website;

            // Set logo preview if exists
            if ($employer->company_logo_path && Storage::disk('public')->exists($employer->company_logo_path)) {
                $this->company_logo_preview = Storage::url($employer->company_logo_path);
            }
        } else {
            // Initialize with user data from registration
            $this->full_name = $this->user->name;
            $this->email = $this->user->email;
        }
    }

    /**
     * Handle company logo upload
     */
    public function updatedCompanyLogo()
    {
        $this->validate([
            'company_logo' => 'image|max:1024',
        ]);

        // Create a temporary URL for preview
        $this->company_logo_preview = $this->company_logo->temporaryUrl();
    }

    /**
     * Skip the setup process
     */
    public function skipSetup()
    {
        // Mark setup as completed but don't require any fields
        $employer = $this->user->employer;

        if (!$employer) {
            // Create a new employer record if it doesn't exist
            $this->user->employer()->create([
                'full_name' => $this->user->name, // Use user's name for full_name
                'setup_completed' => true,
            ]);
        } else {
            // Update the existing record
            $employer->update([
                'full_name' => $this->user->name, // Use user's name for full_name
                'setup_completed' => true,
            ]);
        }

        // Redirect to dashboard
        return redirect()->route('employer.dashboard')->with('status', 'You can complete your profile later.');
    }

    /**
     * Save the employer profile data
     */
    public function saveProfile()
    {
        // Validate form fields - only email is required
        $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ]);

        // Validate company logo if provided
        if ($this->company_logo) {
            $this->validate([
                'company_logo' => 'image|max:1024',
            ]);
        }

        // Update user email if changed
        if ($this->email !== $this->user->email) {
            $this->user->update([
                'email' => $this->email,
                'name' => $this->full_name, // Update name in the users table instead
            ]);
        } else if ($this->full_name !== $this->user->name) {
            // If only name was changed but not email
            $this->user->update([
                'name' => $this->full_name,
            ]);
        }

        // Prepare employer data
        $employerData = [
            'full_name' => $this->full_name,
            'company_name' => $this->company_name,
            'company_description' => $this->company_description,
            'website' => $this->website,
            'setup_completed' => true,
        ];

        // Handle company logo upload
        if ($this->company_logo) {
            $employer = $this->user->employer;

            // Delete old logo if exists
            if ($employer && $employer->company_logo_path) {
                Storage::delete('public/' . $employer->company_logo_path);
            }

            $logoPath = $this->company_logo->store('company-logos', 'public');
            $employerData['company_logo_path'] = $logoPath;
        }

        // Get or create employer record
        $employer = $this->user->employer;

        if ($employer) {
            $employer->update($employerData);
        } else {
            $this->user->employer()->create($employerData);
        }

        // Redirect to dashboard with success message
        return redirect()->route('employer.dashboard')->with('status', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.employer.profile-setup');
    }
}
