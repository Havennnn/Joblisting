<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserSettings extends Component
{
    public $user;
    public $currentEmail;
    public $newEmail;
    public $currentPassword;
    public $newPassword;
    public $newPasswordConfirmation;
    public $activeTab = 'email';

    // Define rules for validation
    protected function rules()
    {
        return [
            'newEmail' => 'required|email|unique:users,email,' . $this->user->id,
            'newPassword' => ['required', 'confirmed', Password::defaults()],
            'currentPassword' => 'required',
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

    public function updateEmail()
    {
        // Validate email and current password
        $this->validate([
            'newEmail' => 'required|email|unique:users,email,' . $this->user->id,
            'currentPassword' => 'required',
        ]);

        // Verify current password
        if (!Hash::check($this->currentPassword, $this->user->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        // Update the email
        $this->user->email = $this->newEmail;
        $this->user->save();

        $this->currentEmail = $this->newEmail;
        $this->reset(['newEmail', 'currentPassword']);
        session()->flash('emailSuccess', 'Your email has been updated successfully.');
    }

    public function updatePassword()
    {
        // Validate passwords
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Verify current password
        if (!Hash::check($this->currentPassword, $this->user->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        // Update the password
        $this->user->password = Hash::make($this->newPassword);
        $this->user->save();

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);
        session()->flash('passwordSuccess', 'Your password has been updated successfully.');
    }

    public function render()
    {
        return view('livewire.user-settings');
    }
}
