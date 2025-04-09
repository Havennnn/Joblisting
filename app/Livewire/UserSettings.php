<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserSettings extends Component
{
    public $user;
    public $currentEmail;
    public $newEmail;
    public $currentPassword;
    public $newPassword;
    public $newPassword_confirmation;
    public $activeTab = 'email';
    public $showEmailForm = true;
    public $emailChangeToken;
    public $emailChangeRequested = false;

    // Define rules for validation
    public function rules()
    {
        return [
            'newEmail' => 'required|email|unique:users,email,' . Auth::id(),
            'currentPassword' => 'required_with:newPassword',
            'newPassword' => 'required_with:currentPassword|min:8|confirmed',
            'newPassword_confirmation' => 'required_with:newPassword',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->currentEmail = $this->user->email;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetValidation();
    }

    public function requestEmailChange()
    {
        $this->validate([
            'newEmail' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        // Generate a unique token for email change
        $this->emailChangeToken = Str::random(60);

        // Store the new email and token in the user's record
        $this->user->email_change_token = $this->emailChangeToken;
        $this->user->pending_email = $this->newEmail;
        $this->user->save();

        // Send confirmation email
        /* Mail::to($this->newEmail)->send(new \App\Mail\EmailChangeConfirmation($this->user, $this->emailChangeToken)); */

        $this->emailChangeRequested = true;
        session()->flash('emailChangeRequested', 'Please check your new email address for a confirmation link.');
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
