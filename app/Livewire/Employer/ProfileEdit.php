<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileEdit extends Component
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

        if (!$employer) {
            // If no employer record exists, create one
            $employer = $this->user->employer()->create([
                'full_name' => $this->user->name,
                'setup_completed' => true,
            ]);
        }

        // Populate form fields from employer data
        $this->full_name = $employer->full_name ?? $this->user->name;
        $this->email = $this->user->email;
        $this->company_name = $employer->company_name;
        $this->company_description = $employer->company_description;
        $this->website = $employer->website;

        // Set company logo preview if exists
        if ($employer->company_logo_path && Storage::disk('public')->exists($employer->company_logo_path)) {
            $this->company_logo_preview = Storage::url($employer->company_logo_path);
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
     * Save the employer profile data with all fields optional
     */
    public function saveProfile()
    {
        // Validate form fields - all fields are optional except email
        $this->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255', // Email remains required as it's essential
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

        // Only update fields that have been changed
        $userData = [];
        $employerData = [];

        // Check user fields for changes
        if ($this->email !== $this->user->email) {
            $userData['email'] = $this->email;
        }

        if ($this->full_name !== $this->user->name) {
            $userData['name'] = $this->full_name;
        }

        // Update user if needed
        if (!empty($userData)) {
            $this->user->update($userData);
        }

        // Get employer record
        $employer = $this->user->employer;

        // Check employer fields for changes
        if ($this->company_name !== $employer->company_name) {
            $employerData['company_name'] = $this->company_name;
        }

        if ($this->company_description !== $employer->company_description) {
            $employerData['company_description'] = $this->company_description;
        }

        if ($this->website !== $employer->website) {
            $employerData['website'] = $this->website;
        }

        // Handle company logo upload
        if ($this->company_logo) {
            // Delete old logo if exists
            if ($employer->company_logo_path) {
                Storage::delete('public/' . $employer->company_logo_path);
            }

            // Store new logo
            $logoPath = $this->company_logo->store('company-logos', 'public');
            $employerData['company_logo_path'] = $logoPath;
        }

        // Update employer if needed
        if (!empty($employerData)) {
            $employer->update($employerData);

            // Show success message
            session()->flash('status', 'Profile updated successfully!');
        } else {
            // No changes were made
            session()->flash('status', 'No changes detected in your profile.');
        }
    }

    public function render()
    {
        return view('livewire.employer.profile-edit');
    }
}
