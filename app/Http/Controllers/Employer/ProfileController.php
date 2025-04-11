<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Profile\EditController;
use App\Http\Controllers\Employer\Profile\ShowController;
use App\Http\Controllers\Employer\Profile\ShowCompanyLogoController;
use App\Http\Controllers\Employer\Profile\UpdateController;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    protected $showController;
    protected $editController;
    protected $updateController;
    protected $showCompanyLogoController;

    public function __construct(
        ShowController $showController,
        EditController $editController,
        UpdateController $updateController,
        ShowCompanyLogoController $showCompanyLogoController
    ) {
        $this->showController = $showController;
        $this->editController = $editController;
        $this->updateController = $updateController;
        $this->showCompanyLogoController = $showCompanyLogoController;
    }

    /**
     * Show employer's profile view page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return $this->showController->__invoke();
    }

    /**
     * Show employer's profile edit page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(): View
    {
        return $this->editController->__invoke();
    }

    /**
     * Update employer's profile information
     *
     * Validates and updates all profile information including file uploads
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        return $this->updateController->__invoke($request);
    }

    /**
     * Securely serve company logo from private storage
     *
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\Response
     */
    public function showCompanyLogo(User $user): Response
    {
        return $this->showCompanyLogoController->__invoke($user);
    }
}
