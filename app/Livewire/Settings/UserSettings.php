<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserSettings extends Component
{
    public $user;
    public $activeTab = 'email';

    // Event listeners to receive events from child components
    protected $listeners = [
        'emailUpdated' => 'handleEmailUpdated',
        'passwordUpdated' => 'handlePasswordUpdated'
    ];

    public function mount()
    {
        $this->user = Auth::user();

        // Set the active tab based on flash data if available
        if (session('active_tab')) {
            $this->activeTab = session('active_tab');
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Handle email updated event from child component
     */
    public function handleEmailUpdated($newEmail = null)
    {
        // You can add additional logic when email is updated if needed
        session()->flash('success', 'Email address has been updated and verified.');
    }

    public function render()
    {
        return view('livewire.settings.user-settings');
    }
}
