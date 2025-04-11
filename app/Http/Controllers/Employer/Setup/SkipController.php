<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\Employer;
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
        $userId = Auth::id();
        $user = User::find($userId);
        $employer = Employer::where('user_id', $userId)->first();

        Log::info('Employer Setup Skip Requested', [
            'user_id' => $userId
        ]);

        try {
            if ($employer) {
                $employer->setup_completed = true;
                $employer->save();
            } else {
                // Create a basic profile if it doesn't exist
                Employer::create([
                    'user_id' => $userId,
                    'company_name' => $user->name . "'s Company",
                    'setup_completed' => true
                ]);
            }

            // Clear any existing session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to ensure the middleware picks up the setup_completed change
            $request->session()->regenerate();

            // Reload the user data to ensure middleware sees the changes
            $user = User::find($userId); // Re-fetch user with fresh data

            // Store successful setup flag in session to bypass middleware check
            Session::put('employer_setup_completed', true);

            Log::info('Employer Setup Skipped Successfully', [
                'user_id' => $userId
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('employer.dashboard')
                ->with('status', 'You can complete your company profile later.');

        } catch (\Exception $e) {
            Log::error('Error skipping employer setup', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.setup')
                ->withErrors(['error' => 'An error occurred while skipping setup: ' . $e->getMessage()]);
        }
    }
}
