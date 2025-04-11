<?php

namespace App\Http\Controllers\Employer\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EditController extends Controller
{
    /**
     * Show employer's profile edit page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        return view('employer.profile-edit');
    }
}
