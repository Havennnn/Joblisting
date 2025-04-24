<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * Show the setup wizard
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        // Ensure the employer_setup_completed flag is set
        // This prevents redirect loops
        Session::put('employer_setup_completed', true);

        $user = Auth::user();
        $employer = $user->employer;

        $data = [];
        if (Session::has('setup_data')) {
            $data = Session::get('setup_data');
        } else if ($employer) {
            $data = [
                'full_name' => $user->name,
                'email' => $user->email,
                'phone_number' => $employer->phone_number,
            ];
        }

        return view('employer.setup', [
            'user' => $user,
            'data' => $data
        ]);
    }
}
