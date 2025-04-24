<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileSetup extends Component
{
    public $full_name;
    public $email;
    public $phone_number;

    public function mount()
    {
        $user = Auth::user();
        $employer = $user->employer;

        $this->full_name = $user->name;
        $this->email = $user->email;

        if ($employer) {
            $this->phone_number = $employer->phone_number;
        }
    }

    public function saveProfile()
    {
        $this->validate([
            'full_name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $employer = $user->employer ?? $user->employer()->create([]);

        // Update user data
        $user->update([
            'name' => $this->full_name,
            'email' => $this->email,
        ]);

        // Update employer profile with contact info only
        $employer->update([
            'phone_number' => $this->phone_number,
            'setup_completed' => true,
        ]);

        session()->flash('message', 'Profile updated successfully!');
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
                'setup_completed' => true
            ]);
        }

        session()->flash('status', 'You can complete your profile later.');
        return redirect()->route('employer.dashboard');
    }

    public function render()
    {
        return view('livewire.employer.profile-setup');
    }
}
