<?php

namespace App\Livewire\Employers;

use App\Livewire\Forms\Employers\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->form->validate();

        $loginAttempt = Auth::guard('employer')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ]);

        if ($loginAttempt) {
            return redirect()->route('employer.dashboard')->with('success', 'Login successful!');
        }

        throw ValidationException::withMessages([
            'form.email' => trans('auth.failed'),
        ]);
    }

    public function render()
    {
        return view('livewire.employers.login');
    }
}
