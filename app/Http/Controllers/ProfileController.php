<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $fakeUserId = 1;

        // Fetch user from users table
        $user = User::where('id', $fakeUserId)->first();

        return view('userProfile', compact('user'));
    }
}
