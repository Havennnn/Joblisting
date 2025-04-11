<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\ApplicantProfile;
use App\Rules\AppropriateFullName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

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
        if (Auth::check() && Auth::user()->isApplicant()) {
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

            if (Auth::user()->isEmployer()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is registered as an employer. Please use employer login.',
                ]);
            }

            // Check if setup is completed
            if (Auth::user()->applicantProfile && !Auth::user()->applicantProfile->setup_completed) {
                // Set a flag in the session to bypass middleware check
                session()->put('applicant_setup_completed', true);
                return redirect()->route('applicant.setup');
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
            if (Auth::user()->isEmployer()) {
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

            if (!Auth::user()->isEmployer()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is registered as an applicant. Please use applicant login.',
                ]);
            }

            // Check if setup is completed
            if (Auth::user()->employer && !Auth::user()->employer->setup_completed) {
                // Set a flag in the session to bypass middleware check
                session()->put('employer_setup_completed', true);
                return redirect()->route('employer.setup');
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
            if (Auth::user()->isEmployer()) {
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
            'name' => [
                'required',
                'string',
                'max:255',
                new AppropriateFullName,
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '.com')) {
                        $fail('The email must end with .com');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'applicant',
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

        // Set a flag in the session to bypass middleware check
        session()->put('applicant_setup_completed', true);

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
            if (Auth::user()->isEmployer()) {
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
            'name' => [
                'required',
                'string',
                'max:255',
                new AppropriateFullName,
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '.com')) {
                        $fail('The email must end with .com');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employer',
        ]);

        // Create employer profile
        $user->employer()->create([
            'full_name' => $request->name,
            'company_name' => $request->company_name ?? null,
            'company_description' => $request->company_description ?? null,
            'setup_completed' => false,
        ]);

        Auth::login($user);

        // Set a flag in the session to bypass middleware check
        session()->put('employer_setup_completed', true);

        return redirect()->route('employer.setup');
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
