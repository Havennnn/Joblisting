<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmployerLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.employer-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        \Log::info('Employer login attempt', ['email' => $request->email]);

        if (Auth::guard('employer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            \Log::info('Employer login successful', ['id' => Auth::guard('employer')->id()]);

            return redirect()->route('employer.dashboard');
        }

        \Log::warning('Employer login failed: Invalid credentials', ['email' => $request->email]);

        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::guard('employer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employer.login');
    }
}
