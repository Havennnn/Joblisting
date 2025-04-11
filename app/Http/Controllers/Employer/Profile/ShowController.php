<?php

namespace App\Http\Controllers\Employer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    /**
     * Show employer's profile view page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('employer.profile-view');
    }
}
