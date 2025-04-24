<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Component
{
    // User data properties
    public $full_name;
    public $phone_number;

    // User model instance
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $employer = $this->user->employer;

        if (!$employer) {
            // If no employer record exists, create one
            $employer = $this->user->employer()->create([
                'setup_completed' => true,
            ]);
        }

        // Populate form fields from employer data
        $this->full_name = $this->user->name;
        $this->phone_number = $employer->phone_number;
    }

    /**
     * Save profile changes
     */
    public function saveProfile()
    {
        // Validate input
        $this->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Update user data
        $this->user->update([
            'name' => $this->full_name,
        ]);

        // Prepare employer data
        $employerData = [
            'phone_number' => $this->phone_number,
        ];

        // Update or create employer profile
        $employer = $this->user->employer;
        if ($employer) {
            $employer->update($employerData);
        } else {
            $this->user->employer()->create($employerData);
        }

        session()->flash('message', 'Profile updated successfully.');

        return redirect()->route('employer.profile.index');
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.employer.profile-edit');
    }
}
