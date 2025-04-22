<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the settings page
     * All functionality is now handled by the UserSettings Livewire component
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('auth.settings.index');
    }
}
