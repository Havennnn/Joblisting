<?php

namespace App\Http\Controllers\Auth\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EmployerDashboardController extends Controller
{
    /**
     * Show the employer dashboard
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('employer.dashboard');
    }
}
