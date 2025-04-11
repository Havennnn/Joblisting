<?php

namespace App\Http\Controllers\Auth\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ApplicantDashboardController extends Controller
{
    /**
     * Show the applicant dashboard
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('applicant.dashboard');
    }
}