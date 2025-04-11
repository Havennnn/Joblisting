<?php

namespace App\Http\Controllers\Applicant\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EditController extends Controller
{
    /**
     * Show applicant's profile edit page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('applicant.profile-edit');
    }
}
