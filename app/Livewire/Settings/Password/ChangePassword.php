<?php

namespace App\Livewire\Settings\Password;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class ChangePassword extends Component
{
    public $user;
    public $currentPassword;
    public $newPassword;
    public $newPassword_confirmation;

    protected function rules()
    {
        return [
            'currentPassword' => 'required|current_password',
            'newPassword' => ['required', 'min:8', 'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
            ],
            'newPassword_confirmation' => 'required|same:newPassword'
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function updatePassword()
    {
        try {
            $this->validate();

            $this->user->update([
                'password' => Hash::make($this->newPassword)
            ]);

            $this->reset(['currentPassword', 'newPassword', 'newPassword_confirmation']);
            session()->flash('passwordSuccess', 'Your password has been updated successfully.');

            // Log the password change
            Log::info('User updated password', ['user_id' => $this->user->id]);

            // Dispatch event for parent component
            $this->dispatch('passwordUpdated');
        } catch (\Exception $e) {
            session()->flash('error', 'Passowrd is Incorrect');
            Log::error('Password update error', ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.settings.password.change-password');
    }
}
