<?php

namespace App\Http\Controllers\Applicant\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * Show the setup wizard based on current step
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $step = Session::get('setup_step', 1);
        $data = Session::get('setup_data', []);

        return view('applicant.setup', compact('user', 'step', 'data'));
    }
}
