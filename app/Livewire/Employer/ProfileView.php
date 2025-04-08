<?php

namespace App\Livewire\Employer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileView extends Component
{
    public $user;
    public $employer;

    public function mount()
    {
        $this->user = Auth::user();
        $this->employer = $this->user->employer;
    }

    public function render()
    {
        return view('livewire.employer.profile-view');
    }
}
