<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileSetup extends Component
{
    use WithFileUploads;

    public $full_name;
    public $email;
    public $company_name;
    public $company_description;
    public $industry;
    public $website;
    public $phone_number;
    public $location;
    public $company_logo;
    public $company_logo_preview;

    public function mount()
    {
        $user = Auth::user();
        $employer = $user->employer;

        $this->full_name = $user->name;
        $this->email = $user->email;

        if ($employer) {
            $this->company_name = $employer->company_name;
            $this->company_description = $employer->company_description;
            $this->industry = $employer->industry;
            $this->website = $employer->website;
            $this->phone_number = $employer->phone_number;
            $this->location = $employer->location;

            if ($employer->company_logo_path) {
                $this->company_logo_preview = Storage::url($employer->company_logo_path);
            }
        }
    }

    public function updatedCompanyLogo()
    {
        $this->validate([
            'company_logo' => 'image|max:2048', // 2MB max
        ]);

        $this->company_logo_preview = $this->company_logo->temporaryUrl();
    }

    public function saveProfile()
    {
        $this->validate([
            'full_name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'company_name' => 'required|min:2|max:255',
            'company_description' => 'required|min:10',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $user = Auth::user();
        $employer = $user->employer ?? $user->employer()->create([]);

        // Update user data
        $user->update([
            'name' => $this->full_name,
            'email' => $this->email,
        ]);

        // Handle company logo upload
        if ($this->company_logo) {
            // Delete old logo if exists
            if ($employer->company_logo_path) {
                Storage::delete($employer->company_logo_path);
            }

            // Store in private storage (local disk) instead of public
            $path = $this->company_logo->store('company-logos', 'local');
            $employer->company_logo_path = $path;
        }

        // Update employer profile
        $employer->update([
            'company_name' => $this->company_name,
            'company_description' => $this->company_description,
            'industry' => $this->industry,
            'website' => $this->website,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
            'setup_completed' => true,
        ]);

        session()->flash('message', 'Company profile updated successfully!');
        return redirect()->route('employer.dashboard');
    }

    public function skipSetup()
    {
        $user = Auth::user();
        $employer = $user->employer;

        if ($employer) {
            $employer->update(['setup_completed' => true]);
        } else {
            // Create a basic profile if it doesn't exist
            $user->employer()->create([
                'company_name' => $user->name . "'s Company",
                'setup_completed' => true
            ]);
        }

        session()->flash('status', 'You can complete your company profile later.');
        return redirect()->route('employer.dashboard');
    }

    public function render()
    {
        return view('livewire.employer.profile-setup');
    }
}
