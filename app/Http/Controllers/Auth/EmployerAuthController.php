<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployerAuthController extends Controller
{
    public function showLogin()
    {
        // If user is already logged in as employer, redirect to dashboard
        if (Auth::check() && Auth::user()->is_employer) {
            return redirect()->route('employer.dashboard');
        }

        return view('employer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::user()->is_employer) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is registered as a job seeker. Please use job seeker login.',
                ]);
            }

            return redirect()->route('employer.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        // If user is already logged in as employer, redirect to dashboard
        if (Auth::check() && Auth::user()->is_employer) {
            return redirect()->route('employer.dashboard');
        }

        return view('employer.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_employer' => true,
        ]);

        Auth::login($user);

        return redirect()->route('employer.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
