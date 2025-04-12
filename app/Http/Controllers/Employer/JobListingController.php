<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\JobListing\CreateController;
use App\Http\Controllers\Employer\JobListing\StoreController;
use App\Http\Controllers\Employer\JobListing\ShowController;
use App\Http\Controllers\Employer\JobListing\EditController;
use App\Http\Controllers\Employer\JobListing\UpdateController;
use App\Http\Controllers\Employer\JobListing\DestroyController;
use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dashboard\ProfileCompletionService;

class JobListingController extends Controller
{
    protected $profileCompletionService;
    protected $createController;
    protected $storeController;
    protected $showController;
    protected $editController;
    protected $updateController;
    protected $destroyController;

    /**
     * Constructor to inject dependencies
     */
    public function __construct(
        ProfileCompletionService $profileCompletionService,
        CreateController $createController,
        StoreController $storeController,
        ShowController $showController,
        EditController $editController,
        UpdateController $updateController,
        DestroyController $destroyController
    ) {
        $this->profileCompletionService = $profileCompletionService;
        $this->createController = $createController;
        $this->storeController = $storeController;
        $this->showController = $showController;
        $this->editController = $editController;
        $this->updateController = $updateController;
        $this->destroyController = $destroyController;
    }

    /**
     * Display a listing of the job posts for the employer.
     */
    public function index(Request $request)
    {
        $employer = Auth::user()->employer;
        $JobPosts = JobPost::where('employer_id', $employer->id)
                           ->orderBy('created_at', 'DESC')
                           ->paginate(10);

        // Get the employer profile completion percentage
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion(Auth::user());

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return view('employer.job-posts.partials.job-list', compact('JobPosts', 'completionPercentage'))->render();
        }

        return view('employer.job-posts.index', compact('JobPosts', 'completionPercentage'));
    }

    /**
     * Show the form for creating a new job post.
     */
    public function create()
    {
        return $this->createController->__invoke();
    }

    /**
     * Store a newly created job post in storage.
     */
    public function store(Request $request)
    {
        return $this->storeController->__invoke($request);
    }

    /**
     * Display the specified job post.
     */
    public function show($id)
    {
        return $this->showController->__invoke($id);
    }

    /**
     * Show the form for editing the specified job post.
     */
    public function edit($id)
    {
        return $this->editController->__invoke($id);
    }

    /**
     * Update the specified job post in storage.
     */
    public function update(Request $request, $id)
    {
        return $this->updateController->__invoke($request, $id);
    }

    /**
     * Remove the specified job post from storage.
     */
    public function destroy($id)
    {
        return $this->destroyController->__invoke($id);
    }
}
