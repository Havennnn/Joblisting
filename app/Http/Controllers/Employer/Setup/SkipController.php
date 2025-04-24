<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SkipController extends Controller
{
    /**
     * Skip the setup process
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $user = Auth::user();
        $employer = $user->employer;

        if ($employer) {
            $employer->update(['setup_completed' => true]);
        } else {
            $user->employer()->create([
                'setup_completed' => true
            ]);
        }

        // Clear any stored setup data
        Session::forget(['setup_data', 'employer_setup_completed']);

        return redirect()->route('employer.dashboard')
            ->with('status', 'You can complete your profile later.');
    }
}
