<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employer;
use Illuminate\Support\Facades\Hash;

class EmployerAuthController extends Controller
{
    // Employer Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('employer')->attempt($credentials)) {
            return redirect()->route('employer.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Employer Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employers,email',
            'password' => 'required|min:6|confirmed'
        ]);

        Employer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('employer.login')->with('success', 'Registration successful! Please log in.');
    }

    // Employer Logout
    public function logout()
    {
        Auth::guard('employer')->logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
