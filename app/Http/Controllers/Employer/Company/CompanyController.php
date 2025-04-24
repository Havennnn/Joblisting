<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Jobs\JobPost;
use App\Models\Users\Employer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CompanyInvitationNotification;
use App\Notifications\InvitationAccepted;

/**
 * Central controller for company management
 */
class CompanyController extends Controller
{
    /**
     * Current authenticated user
     */
    protected $user;

    /**
     * Current employer
     */
    protected $employer;

    /**
     * Current company
     */
    protected $company;

    /**
     * Whether the current user is the owner of the company
     */
    protected $isOwner = false;

    /**
     * Constructor to set up common properties
     */
    public function __construct()
    {
        $this->setupUserAndCompany();
    }

    /**
     * Set up user and company properties
     */
    protected function setupUserAndCompany()
    {
        if (Auth::check()) {
            $this->user = Auth::user();
            $this->employer = $this->user->employer;
            $this->company = $this->employer ? $this->employer->company : null;

            if ($this->company) {
                $firstEmployer = $this->company->employers()->orderBy('created_at')->first();
                $this->isOwner = $firstEmployer && $firstEmployer->id === $this->employer->id;
            }
        }
    }

    /**
     * Display the company management page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pendingInvitations = [];
        $receivedInvitations = [];
        $companyJobs = null;

        if ($this->company) {
            $pendingInvitations = CompanyInvitation::where('company_id', $this->company->id)
                ->where('status', 'pending')
                ->get();

            $employerIds = $this->company->employers()->pluck('id')->toArray();
            $companyJobs = JobPost::whereIn('employer_id', $employerIds)
                ->with('employer.user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $receivedInvitations = CompanyInvitation::where('email', $this->user->email)
                ->where('status', 'pending')
                ->with('company', 'creator')
                ->get();
        }

        return view('employer.company.index', [
            'company' => $this->company,
            'pendingInvitations' => $pendingInvitations,
            'receivedInvitations' => $receivedInvitations,
            'companyJobs' => $companyJobs,
            'isOwner' => $this->isOwner
        ]);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $company = new Company();
        $company->name = $validated['name'];
        $company->industry = $validated['industry'];
        $company->description = $validated['description'];
        $company->website = $validated['website'] ?? null;
        $company->location = $validated['location'];
        $company->is_verified = false;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company-logos', 'public');
            $company->logo_path = $path;
        }

        $company->save();

        $this->employer->company_id = $company->id;
        $this->employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Company created successfully! You are now the owner of this company.');
    }

    /**
     * Kick a member from the company.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function kickMember($id)
    {
        if (!$this->company || $this->employer->id === (int)$id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You cannot remove yourself from the company.');
        }

        $employer = Employer::findOrFail($id);

        if ($employer->company_id !== $this->company->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This employer is not a member of your company.');
        }

        $employer->company_id = null;
        $employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Member has been removed from the company.');
    }

    /**
     * Display a job post within the company context
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewJobPost($id)
    {
        if (!$this->company) {
            return redirect()->route('employer.JobPost.show', $id);
        }

        $companyEmployerIds = $this->company->employers()->pluck('id')->toArray();
        $jobPost = JobPost::with(['employer.user', 'applications'])->findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        return view('employer.company.job-post-view', [
            'jobPost' => $jobPost,
            'company' => $this->company,
            'isOwner' => $this->isOwner
        ]);
    }

    /**
     * Edit form for a job post within the company context
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function editJobPost($id)
    {
        if (!$this->company) {
            return redirect()->route('employer.JobPost.edit', $id);
        }

        $companyEmployerIds = $this->company->employers()->pluck('id')->toArray();
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        if (!$this->isOwner && $jobPost->employer_id !== $this->employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to edit this job post.');
        }

        return view('employer.job-posts.edit', [
            'jobPost' => $jobPost,
            'company' => $this->company,
            'isOwner' => $this->isOwner
        ]);
    }

    /**
     * Delete a job post
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteJobPost($id)
    {
        if (!$this->company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must belong to a company to perform this action.');
        }

        $companyEmployerIds = $this->company->employers()->pluck('id')->toArray();
        $jobPost = JobPost::findOrFail($id);

        if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
            return redirect()->route('employer.company.index')
                ->with('error', 'This job post does not belong to your company.');
        }

        if (!$this->isOwner && $jobPost->employer_id !== $this->employer->id) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You do not have permission to delete this job post.');
        }

        $jobPost->delete();

        return redirect()->route('employer.company.index')
            ->with('success', 'Job post has been deleted successfully.');
    }

    /**
     * Display the invitation form
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showInviteForm()
    {
        if (!$this->company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must create a company before inviting others.');
        }

        $pendingInvitations = CompanyInvitation::where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->get();

        return view('employer.company.invite', [
            'company' => $this->company,
            'pendingInvitations' => $pendingInvitations
        ]);
    }

    /**
     * Send an invitation to join the company
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendInvite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        if (!$this->company) {
            return back()->with('error', 'You must create a company before inviting others.');
        }

        $existingUser = User::where('email', $validated['email'])->first();

        if ($existingUser) {
            if (!$existingUser->isEmployer()) {
                return back()->with('error', 'This email belongs to a user who is not registered as an employer.');
            }

            if ($existingUser->employer && $existingUser->employer->company_id == $this->company->id) {
                return back()->with('error', 'This person is already part of your company.');
            }

            if ($existingUser->employer && $existingUser->employer->company_id) {
                $otherCompany = Company::find($existingUser->employer->company_id);
                if ($otherCompany) {
                    return back()->with('error', 'This employer is already associated with "' . $otherCompany->name . '". They must leave their current company before joining yours.');
                } else {
                    return back()->with('error', 'This employer is already associated with another company. They must leave their current company before joining yours.');
                }
            }
        }

        $existingInvitation = CompanyInvitation::where('email', $validated['email'])
            ->where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->first();

        if ($existingInvitation) {
            return back()->with('error', 'An invitation has already been sent to this email.');
        }

        $invitation = new CompanyInvitation();
        $invitation->company_id = $this->company->id;
        $invitation->email = $validated['email'];
        $invitation->name = $existingUser ? $existingUser->name : null;
        $invitation->token = Str::random(64);
        $invitation->created_by = $this->user->id;
        $invitation->status = 'pending';
        $invitation->save();

        try {
            if ($existingUser) {
                $existingUser->notify(new CompanyInvitationNotification($invitation));
            } else {
                Notification::route('mail', [
                    $validated['email'] => $existingUser ? $existingUser->name : 'Invited Employer',
                ])->notify(new CompanyInvitationNotification($invitation));
            }

            if ($existingUser) {
                $existingUser->notifications()->create([
                    'type' => 'App\Notifications\CompanyInvitationNotification',
                    'data' => [
                        'type' => 'company_invitation',
                        'invitation_id' => $invitation->id,
                        'company_id' => $this->company->id,
                        'company_name' => $this->company->name,
                        'sender_name' => $this->user->name,
                        'token' => $invitation->token,
                    ],
                ]);
            }

            return back()->with('success', 'Invitation sent successfully to ' . $validated['email']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send invitation. Please try again later.');
        }
    }

    /**
     * Get the User model instead of Authenticatable
     *
     * @return User
     */
    protected function getTypedUser(): User
    {
        // Cast the Auth::user() to the specific User model
        /** @var User */
        $user = User::find(Auth::id());
        return $user;
    }

    /**
     * Accept a company invitation
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptInvite($token)
    {
        $invitation = CompanyInvitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (!Auth::check()) {
            session(['company_invitation_token' => $token]);
            return redirect()->route('employer.login')
                ->with('info', 'Please log in or register to accept the company invitation.');
        }

        if (!$this->employer) {
            return redirect()->route('employer.setup.index')
                ->with('info', 'Please complete your employer profile before accepting this invitation.');
        }

        if ($this->employer->company_id) {
            $currentCompany = Company::find($this->employer->company_id);
            $invitingCompany = Company::find($invitation->company_id);

            $companyName = $currentCompany ? $currentCompany->name : 'a company';
            $invitingCompanyName = $invitingCompany ? $invitingCompany->name : 'the inviting company';

            return redirect()->route('employer.company.index')
                ->with('error', "You are already part of {$companyName}. You must leave your current company before you can join {$invitingCompanyName}.");
        }

        $this->employer->company_id = $invitation->company_id;
        $this->employer->save();

        $invitation->status = 'accepted';
        $invitation->accepted_by = $this->user->id;
        $invitation->accepted_at = now();
        $invitation->save();

        $creator = User::find($invitation->created_by);
        if ($creator) {
            try {
                $creator->notify(new InvitationAccepted($invitation, $this->getTypedUser()));
            } catch (\Exception $e) {
                // Continue with acceptance even if notification fails
            }
        }

        return redirect()->route('employer.company.index')
            ->with('success', 'You have successfully joined ' . $invitation->company->name . '.');
    }

    /**
     * Cancel an invitation
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelInvite($id)
    {
        if (!$this->company) {
            return redirect()->route('employer.company.index');
        }

        $invitation = CompanyInvitation::where('id', $id)
            ->where('company_id', $this->company->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $invitation->status = 'cancelled';
        $invitation->save();

        return back()->with('success', 'Invitation cancelled successfully.');
    }

    /**
     * Display the company edit form
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit()
    {
        if (!$this->company || !$this->isOwner) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must be the owner of the company to edit its details.');
        }

        return view('employer.company.edit', [
            'company' => $this->company
        ]);
    }

    /**
     * Update the company details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if (!$this->company || !$this->isOwner) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must be the owner of the company to update its details.');
        }

        $validated = $request->validate([
            'description' => 'required|string|max:1000',
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $this->company->description = $validated['description'];
        $this->company->website = $validated['website'] ?? null;
        $this->company->location = $validated['location'];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($this->company->logo_path) {
                Storage::disk('public')->delete($this->company->logo_path);
            }
            $path = $request->file('logo')->store('company-logos', 'public');
            $this->company->logo_path = $path;
        }

        $this->company->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Company details updated successfully.');
    }
}
