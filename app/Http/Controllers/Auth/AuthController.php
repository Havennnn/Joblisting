<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ApplicantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * =========================================================================
     * Applicant Login Methods
     * =========================================================================
     */

    /**
     * Show the applicant login form
     */
    public function showApplicantLogin()
    {
        if (Auth::check() && !Auth::user()->is_employer) {
            return redirect()->route('applicant.dashboard');
        }

        return view('applicant.login');
    }

    /**
     * Handle an applicant login request
     */
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

    /**
     * =========================================================================
     * Employer Login Methods
     * =========================================================================
     */

    /**
     * Show the employer login form
     */
    public function showEmployerLogin()
    {
        // Redirect authenticated users to their dashboard
        if (Auth::check()) {
            if (Auth::user()->is_employer) {
                return redirect()->route('employer.dashboard');
            }
            return redirect()->route('applicant.dashboard');
        }

        return view('employer.login');
    }

    /**
     * Handle an employer login request
     */
    public function loginEmployer(Request $request)
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
                    'email' => 'This account is registered as an applicant. Please use applicant login.',
                ]);
            }

            return redirect()->intended(route('employer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * =========================================================================
     * Applicant Registration Methods
     * =========================================================================
     */

    /**
     * Show the applicant registration form
     */
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

    /**
     * Handle a registration request for a new applicant
     */
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
        ]);

        // Create applicant profile
        $user->applicantProfile()->create([
            'full_name' => $request->name,
            'location' => $request->location,
            // Default values for required fields
            'phone_number' => null,
            'setup_completed' => false,
        ]);

        Auth::login($user);

        return redirect()->route('applicant.setup');
    }

    /**
     * =========================================================================
     * Employer Registration Methods
     * =========================================================================
     */

    /**
     * Show the employer registration form
     */
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

    /**
     * Handle a registration request for a new employer
     */
    public function registerEmployer(Request $request)
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
            'is_employer' => true,
        ]);

        // Create employer profile
        $user->employer()->create([
            'full_name' => $request->name,
            'company_name' => $request->company_name ?? null,
            'company_description' => $request->company_description ?? null,
            'setup_completed' => false,
        ]);

        Auth::login($user);

        return redirect()->route('employer.dashboard');
    }

    /**
     * =========================================================================
     * Dashboard Methods
     * =========================================================================
     */

    /**
     * Show the applicant dashboard
     */
    public function applicantDashboard()
    {
        return view('applicant.dashboard');
    }

    /**
     * Show the employer dashboard
     */
    public function employerDashboard()
    {
        return view('employer.dashboard');
    }

    /**
     * =========================================================================
     * Authentication Shared Methods
     * =========================================================================
     */

    /**
     * Log the user out of the application
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
