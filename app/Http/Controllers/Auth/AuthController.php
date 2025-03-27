<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showApplicantLogin()
    {
        if (Auth::check() && !Auth::user()->is_employer) {
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.login');
    }

    public function loginApplicant(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->is_employer) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is registered as an employer. Please use employer login.',
                ]);
            }

            return redirect()->intended(route('applicant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Applicant registration methods
    public function showApplicantRegister()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.register');
    }

    public function registerApplicant(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_employer' => false,
            'setup_completed' => false,
        ]);

        Auth::login($user);

        return redirect()->route('applicant.setup');
    }

    // Employer registration methods
    public function showEmployerRegister()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('employer.register');
    }

    public function registerEmployer(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'company_name' => ['required', 'string', 'max:255'],
            'company_description' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_employer' => true,
        ]);

        // Create employer profile
        $user->employer()->create([
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
        ]);

        Auth::login($user);

        return redirect()->route('employer.dashboard');
    }

    // Dashboard methods
    public function applicantDashboard()
    {
        return view('applicant.dashboard');
    }

    public function employerDashboard()
    {
        return view('employer.dashboard');
    }

    public function showRegister()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('auth.register');
    }

    public function showRegisterNextPage()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('auth.register-next-page');
    }

    public function showEmployerLogin()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('auth.employer.employer-login');
    }
}
