<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display the company management page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employer = Auth::user()->employer;
        $company = $employer ? $employer->company : null;

        return view('employer.company.index', compact('company'));
    }
}
