<?php

namespace App\Http\Controllers\Applicant\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ShowController extends Controller
{
    /**
     * Show applicant's profile view page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('applicant.profile-view');
    }
}
