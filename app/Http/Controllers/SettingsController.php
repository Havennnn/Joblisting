<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Show the user settings page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }
}
