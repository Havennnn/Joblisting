<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.employer-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $employer = Employer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('employer')->login($employer);

        return redirect()->route('employer.dashboard'); // Change to your employer dashboard route
    }
}
