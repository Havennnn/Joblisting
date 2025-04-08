<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profileCompletion = $this->calculateProfileCompletion($user);

        return view('employer.dashboard', compact('profileCompletion'));
    }

    private function calculateProfileCompletion($user)
    {
        $totalFields = 0;
        $completedFields = 0;

        // Company Name
        $totalFields++;
        if ($user->company_name) $completedFields++;

        // Company Description
        $totalFields++;
        if ($user->company_description) $completedFields++;

        // Company Logo
        $totalFields++;
        if ($user->company_logo) $completedFields++;

        // Company Website
        $totalFields++;
        if ($user->company_website) $completedFields++;

        // Company Address
        $totalFields++;
        if ($user->company_address) $completedFields++;

        // Company Phone
        $totalFields++;
        if ($user->company_phone) $completedFields++;

        // Company Size
        $totalFields++;
        if ($user->company_size) $completedFields++;

        // Industry
        $totalFields++;
        if ($user->industry) $completedFields++;

        // Founded Year
        $totalFields++;
        if ($user->founded_year) $completedFields++;

        // Mission Statement
        $totalFields++;
        if ($user->mission_statement) $completedFields++;

        // Vision Statement
        $totalFields++;
        if ($user->vision_statement) $completedFields++;

        // Values
        $totalFields++;
        if ($user->values) $completedFields++;

        // Benefits
        $totalFields++;
        if ($user->benefits) $completedFields++;

        // Culture
        $totalFields++;
        if ($user->culture) $completedFields++;

        // Social Media Links
        $totalFields++;
        if ($user->social_media_links) $completedFields++;

        // Contact Person
        $totalFields++;
        if ($user->contact_person) $completedFields++;

        // Contact Email
        $totalFields++;
        if ($user->contact_email) $completedFields++;

        // Contact Phone
        $totalFields++;
        if ($user->contact_phone) $completedFields++;

        // Additional Information
        $totalFields++;
        if ($user->additional_info) $completedFields++;

        return round(($completedFields / $totalFields) * 100);
    }
}
