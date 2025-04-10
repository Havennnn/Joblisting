<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Services\Dashboard\ProfileCompletionService;

class DashboardController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    public function index()
    {
        $user = Auth::user();
        $employer = $user->employer;

        // Get the count of active job posts for the employer
        $activeJobPosts = JobPost::where('employer_id', $employer->id)
                                ->where('auto_delete_at', '>', now())
                                ->count();

        // Get the count of total applications for the employer
        $totalApplications = JobApplication::where('employer_id', $employer->id)->count();

        // Get new/unread applications count
        $newApplications = JobApplication::where('employer_id', $employer->id)
                                ->whereNull('viewed_at')
                                ->count();

        // Get applications by status
        $pendingApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'pending')
                                ->count();

        $reviewingApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'reviewing')
                                ->count();

        $acceptedApplications = JobApplication::where('employer_id', $employer->id)
                                ->where('status', 'accepted')
                                ->count();

        // Get recent applications for the employer
        $recentApplications = JobApplication::where('employer_id', $employer->id)
                                    ->with(['job', 'applicant'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Calculate profile completion percentage
        $profileCompletion = $this->profileCompletionService->calculateEmployerCompletion($user);

        return view('employer.dashboard', compact(
            'activeJobPosts',
            'totalApplications',
            'newApplications',
            'pendingApplications',
            'reviewingApplications',
            'acceptedApplications',
            'recentApplications',
            'profileCompletion'
        ));
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
