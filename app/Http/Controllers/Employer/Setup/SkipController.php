<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SkipController extends Controller
{
    /**
     * Skip the setup process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $employer = $user->employer;

        Log::info('Employer Setup Skip Requested', [
            'user_id' => $user->id
        ]);

        try {
            if ($employer) {
                $employer->update(['setup_completed' => true]);
            } else {
                // Create a basic profile if it doesn't exist
                $user->employer()->create([
                    'company_name' => $user->name . "'s Company",
                    'setup_completed' => true
                ]);
            }

            // Clear any existing session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('employer_setup_completed', true);

            Log::info('Employer Setup Skipped Successfully', [
                'user_id' => $user->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('employer.dashboard')
                ->with('status', 'You can complete your company profile later.');

        } catch (\Exception $e) {
            Log::error('Error skipping employer setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.setup')
                ->withErrors(['error' => 'An error occurred while skipping setup: ' . $e->getMessage()]);
        }
    }
}
