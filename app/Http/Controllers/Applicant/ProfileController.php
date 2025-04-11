<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Profile\DownloadResumeController;
use App\Http\Controllers\Applicant\Profile\EditController;
use App\Http\Controllers\Applicant\Profile\ShowController;
use App\Http\Controllers\Applicant\Profile\ShowProfilePictureController;
use App\Http\Controllers\Applicant\Profile\UpdateController;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfileController extends Controller
{
    protected $showController;
    protected $editController;
    protected $updateController;
    protected $showProfilePictureController;
    protected $downloadResumeController;

    public function __construct(
        ShowController $showController,
        EditController $editController,
        UpdateController $updateController,
        ShowProfilePictureController $showProfilePictureController,
        DownloadResumeController $downloadResumeController
    ) {
        $this->showController = $showController;
        $this->editController = $editController;
        $this->updateController = $updateController;
        $this->showProfilePictureController = $showProfilePictureController;
        $this->downloadResumeController = $downloadResumeController;
    }

    /**
     * Show applicant's profile view page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        return $this->showController->__invoke();
    }

    /**
     * Show applicant's profile edit page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        return $this->editController->__invoke();
    }

    /**
     * Update applicant's profile information
     *
     * Validates and updates all profile information including file uploads
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        return $this->updateController->__invoke($request);
    }

    /**
     * Securely serve profile picture from private storage
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function showProfilePicture(User $user)
    {
        return $this->showProfilePictureController->__invoke($user);
    }

    /**
     * Securely download resume from private storage
     *
     * @param \App\Models\User $user
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadResume(User $user)
    {
        return $this->downloadResumeController->__invoke($user);
    }
}
