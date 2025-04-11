<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Profile\EditController;
use App\Http\Controllers\Employer\Profile\ShowController;
use App\Http\Controllers\Employer\Profile\ShowCompanyLogoController;
use App\Http\Controllers\Employer\Profile\UpdateController;
use App\Models\User;
use Illuminate\Http\Request;

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
     */
    public function show()
    {
        return $this->showController->__invoke();
    }

    /**
     * Show employer's profile edit page
     */
    public function edit()
    {
        return $this->editController->__invoke();
    }

    /**
     * Update employer's profile information
     *
     * Validates and updates all profile information including file uploads
     */
    public function update(Request $request)
    {
        return $this->updateController->__invoke($request);
    }

    /**
     * Securely serve company logo from private storage
     */
    public function showCompanyLogo(User $user)
    {
        return $this->showCompanyLogoController->__invoke($user);
    }
}
