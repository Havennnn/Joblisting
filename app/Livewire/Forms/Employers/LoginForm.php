<?php

namespace App\Livewire\Forms\Employers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';
}
