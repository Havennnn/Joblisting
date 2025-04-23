<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\CompanyInvitation;
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
        $user = Auth::user();
        $employer = $user->employer;
        $company = $employer ? $employer->company : null;

        $pendingInvitations = [];
        $receivedInvitations = [];

        if ($company) {
            // Fetch outgoing invitations if user has a company
            $pendingInvitations = CompanyInvitation::where('company_id', $company->id)
                ->where('status', 'pending')
                ->get();
        } else {
            // Fetch incoming invitations if user doesn't have a company
            $receivedInvitations = CompanyInvitation::where('email', $user->email)
                ->where('status', 'pending')
                ->with('company', 'creator')
                ->get();
        }

        return view('employer.company.index', compact('company', 'pendingInvitations', 'receivedInvitations'));
    }
}
