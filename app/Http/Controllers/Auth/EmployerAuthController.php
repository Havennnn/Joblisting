<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Livewire\Forms\Employers\LoginForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employer;
use Illuminate\Support\Facades\Hash;

class EmployerAuthController extends Controller
{

    public LoginForm $form;

    public function loginForm(Request $request)
    {
        return view('employers.auth.login');
    }

    public function login(Request $request)
    {
        $this->form->login();

        return redirect()->route('employer.dashboard')->with('success', 'Login successful!');
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
