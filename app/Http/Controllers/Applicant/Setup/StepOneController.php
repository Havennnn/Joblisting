<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StepOneController extends Controller
{
    /**
     * Process step 1 (Basic Information)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer|min:18',
        ]);

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 2);

        return redirect()->route('applicant.setup');
    }
}
