<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class UserSettings extends Component
{
    public $user;
    public $currentEmail;
    public $currentPassword;
    public $newPassword;
    public $newPassword_confirmation;
    public $activeTab = 'email';
    public $emailChangeRequested = false;

    // Define rules for validation
    public function rules()
    {
        return [
            'currentPassword' => 'required_with:newPassword',
            'newPassword' => 'required_with:currentPassword|min:8|confirmed',
            'newPassword_confirmation' => 'required_with:newPassword',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->currentEmail = $this->user->email;

        // Check if there's a pending email change
        $this->emailChangeRequested = session()->has('pending_email_change');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetValidation();
    }

    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => 'required|current_password',
            'newPassword' => 'required|min:8|confirmed',
            'newPassword_confirmation' => 'required|same:newPassword'
        ]);

        $this->user->update([
            'password' => Hash::make($this->newPassword)
        ]);

        $this->reset(['currentPassword', 'newPassword', 'newPassword_confirmation']);
        session()->flash('passwordSuccess', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.user-settings');
    }
}
