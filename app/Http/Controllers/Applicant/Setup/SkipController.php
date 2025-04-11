<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use App\Models\ApplicantProfile;
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
        $profile = $user->applicantProfile;

        Log::info('Applicant Setup Skip Requested', [
            'user_id' => $user->id
        ]);

        try {
            if ($profile) {
                $profile->update(['setup_completed' => true]);
            } else {
                // Create a basic profile if it doesn't exist
                $profile = ApplicantProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'full_name' => $user->name,
                        'setup_completed' => true
                    ]
                );
            }

            // Clear any existing session data
            Session::forget(['setup_step', 'setup_data']);

            // Regenerate session to update middleware checks
            $request->session()->regenerate();

            // Reload the user with fresh relationship data to ensure middleware sees the changes
            Auth::user()->refresh();

            // Store successful setup flag in session to bypass middleware check
            Session::put('applicant_setup_completed', true);

            Log::info('Applicant Setup Skipped Successfully', [
                'user_id' => $user->id
            ]);

            // Use direct redirect with 'with' method for flash message
            return redirect()->route('applicant.dashboard')
                ->with('status', 'You can complete your profile later.');
        } catch (\Exception $e) {
            Log::error('Error skipping applicant setup', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('applicant.setup')
                ->withErrors(['error' => 'An error occurred while skipping setup: ' . $e->getMessage()]);
        }
    }
}
