<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileView extends Component
{
    public $user;
    public $profile;

    public function mount()
    {
        $this->user = Auth::user();
        $this->profile = $this->user->applicantProfile;
    }

    public function render()
    {
        return view('livewire.applicant.profile-view');
    }
}
