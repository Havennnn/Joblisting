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
    public $industry;
    public $website;
    public $phone_number;
    public $location;

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
        $this->industry = $employer->industry;
        $this->website = $employer->website;
        $this->phone_number = $employer->phone_number;
        $this->location = $employer->location;

        // Set company logo preview if exists
        if ($employer->company_logo_path) {
            $this->company_logo_preview = route('employer.profile.logo', ['user' => $this->user->id]);
        }
    }

    /**
     * Handle company logo upload
     */
    public function updatedCompanyLogo()
    {
        $this->validate([
            'company_logo' => 'image|max:2048', // 2MB max
        ]);

        $this->company_logo_preview = $this->company_logo->temporaryUrl();
    }

    /**
     * Save profile changes
     */
    public function saveProfile()
    {
        // Validate input
        $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Update user data
        $this->user->update([
            'name' => $this->full_name,
            'email' => $this->email,
        ]);

        // Prepare employer data
        $employerData = [
            'full_name' => $this->full_name,
            'company_name' => $this->company_name,
            'company_description' => $this->company_description,
            'industry' => $this->industry,
            'website' => $this->website,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
        ];

        // Handle company logo upload
        if ($this->company_logo) {
            // Delete old company logo if it exists
            if ($this->user->employer && $this->user->employer->company_logo_path) {
                Storage::delete($this->user->employer->company_logo_path);
            }

            // Store in private storage (local disk)
            $path = $this->company_logo->store('company-logos', 'local');
            $employerData['company_logo_path'] = $path;
        }

        // Update or create employer profile
        $employer = $this->user->employer;
        if ($employer) {
            $employer->update($employerData);
        } else {
            $this->user->employer()->create($employerData);
        }

        session()->flash('status', 'Profile updated successfully!');
        return redirect()->route('employer.profile');
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.employer.profile-edit');
    }
}
