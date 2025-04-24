<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Jobs\JobPost;
use App\Models\Users\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $companyJobs = null;
        $isOwner = false;

        if ($company) {
            // Fetch outgoing invitations if user has a company
            $pendingInvitations = CompanyInvitation::where('company_id', $company->id)
                ->where('status', 'pending')
                ->get();

            // Determine if current user is the company owner (first employer to join)
            $firstEmployer = $company->employers()->orderBy('created_at')->first();
            $isOwner = $firstEmployer && $firstEmployer->id === $employer->id;

            // Fetch all job posts from all employers in this company with pagination
            $employerIds = $company->employers()->pluck('id')->toArray();
            $companyJobs = JobPost::whereIn('employer_id', $employerIds)
                ->with('employer.user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Fetch incoming invitations if user doesn't have a company
            $receivedInvitations = CompanyInvitation::where('email', $user->email)
                ->where('status', 'pending')
                ->with('company', 'creator')
                ->get();
        }

        return view('employer.company.index', compact(
            'company',
            'pendingInvitations',
            'receivedInvitations',
            'companyJobs',
            'isOwner'
        ));
    }

    /**
     * Display the company creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('employer.company.create');
    }

    /**
     * Store a newly created company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'website' => 'nullable|url|max:255',
            'founding_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Create company record
        $company = new Company();
        $company->name = $validated['name'];
        $company->industry = $validated['industry'];
        $company->description = $validated['description'];
        $company->website = $validated['website'] ?? null;
        $company->founding_year = $validated['founding_year'] ?? null;
        $company->location = $validated['location'];
        $company->size = $validated['size'];
        $company->is_verified = false; // New companies start unverified

        // Handle company logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company-logos', 'public');
            $company->logo_path = $path;
        }

        $company->save();

        // Associate the current employer with the new company
        $employer = Auth::user()->employer;
        $employer->company_id = $company->id;
        $employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Company created successfully! You are now the owner of this company.');
    }

    /**
     * Kick a member from the company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function kickMember(Request $request, $id)
    {
        $user = Auth::user();
        $currentEmployer = $user->employer;
        $company = $currentEmployer->company;

        // Check if user is authorized (company owner)
        if (!$company || $currentEmployer->id === (int)$id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You cannot remove yourself from the company.');
        }

        // Find the employer to kick
        $employer = Employer::findOrFail($id);

        // Ensure the employer belongs to the same company
        if ($employer->company_id !== $company->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This employer is not a member of your company.');
        }

        // Remove the employer from the company
        $employer->company_id = null;
        $employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Member has been removed from the company.');
    }

    /**
     * Display a job post within the company context
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function viewJobPost($id)
    {
        $user = Auth::user();
        $employer = $user->employer;
        $company = $employer->company;

        if (!$company) {
            return redirect()->route('employer.JobPost.show', $id);
        }

        // Get company's employers IDs
        $companyEmployerIds = $company->employers()->pluck('id')->toArray();

        // Find the job post and verify it belongs to the company
        $jobPost = JobPost::with(['employer.user', 'applications'])->findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        // Check if user is company owner
        $firstEmployer = $company->employers()->orderBy('created_at')->first();
        $isOwner = $firstEmployer && $firstEmployer->id === $employer->id;

        return view('employer.company.job-post-view', compact('jobPost', 'company', 'isOwner'));
    }

    /**
     * Edit form for a job post within the company context
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editJobPost($id)
    {
        $user = Auth::user();
        $employer = $user->employer;
        $company = $employer->company;

        if (!$company) {
            return redirect()->route('employer.JobPost.edit', $id);
        }

        // Get company's employers IDs
        $companyEmployerIds = $company->employers()->pluck('id')->toArray();

        // Find the job post and verify it belongs to the company
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        // Check if user is company owner
        $firstEmployer = $company->employers()->orderBy('created_at')->first();
        $isOwner = $firstEmployer && $firstEmployer->id === $employer->id;

        // Redirect if not owner and not the post creator
        if (!$isOwner && $jobPost->employer_id !== $employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to edit this job post.');
        }

        // Pass the job post to the edit view
        return view('employer.job-posts.edit', compact('jobPost', 'company', 'isOwner'));
    }

    /**
     * Delete a job post
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteJobPost($id)
    {
        $user = Auth::user();
        $employer = $user->employer;
        $company = $employer->company;

        if (!$company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must belong to a company to perform this action.');
        }

        // Get company's employers IDs
        $companyEmployerIds = $company->employers()->pluck('id')->toArray();

        // Find the job post and verify it belongs to the company
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        // Check if user is company owner
        $firstEmployer = $company->employers()->orderBy('created_at')->first();
        $isOwner = $firstEmployer && $firstEmployer->id === $employer->id;

        // Check if user can delete this post
        if (!$isOwner && $jobPost->employer_id !== $employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to delete this job post.');
        }

        // Delete the job post
        $jobPost->delete();

        return redirect()->route('employer.company.index')
            ->with('success', 'Job post has been deleted successfully.');
    }
}
