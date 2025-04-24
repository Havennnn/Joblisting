<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProcessController extends Controller
{
    /**
     * Process setup information
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Store in session just in case
        Session::put('setup_data', $validated);

        $user = Auth::user();

        // Update user details
        $user->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
        ]);

        // Update or create employer profile
        $employer = $user->employer;
        if ($employer) {
            $employer->update([
                'phone_number' => $validated['phone_number'],
                'setup_completed' => true,
            ]);
        } else {
            $user->employer()->create([
                'phone_number' => $validated['phone_number'],
                'setup_completed' => true,
            ]);
        }

        // Clear session data
        Session::forget(['setup_data', 'employer_setup_completed']);

        return redirect()->route('employer.dashboard')
            ->with('status', 'Profile setup completed successfully!');
    }
}
