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
            'company_logo' => 'image|max:2048', // 2MB max
        ]);

        $this->company_logo_preview = $this->company_logo->temporaryUrl();
    }

    /**
     * Save the employer profile data with all fields optional
     */
    public function saveProfile()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
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

        // Ensure employer profile exists
        $employer = $user->employer ?? $user->employer()->create([]);

        // Handle company logo upload
        if ($this->company_logo) {
            // Delete old logo if exists
            if ($employer->company_logo_path) {
                Storage::delete('public/' . $employer->company_logo_path);
            }

            $path = $this->company_logo->store('company-logos', 'public');
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

        session()->flash('status', 'Company profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.employer.profile-edit');
    }
}
