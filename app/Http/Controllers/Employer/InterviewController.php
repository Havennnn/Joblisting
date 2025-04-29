<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

class InterviewController extends Controller
{
    /**
     * Display the interview scheduling calendar
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('employer.interviews.index');
    }
}
