<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LandingPage\JobController;
use App\Http\Controllers\LandingPage\LandingController;
use App\Models\Jobs\JobPost;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    protected $jobController;
    protected $landingController;

    public function __construct(JobController $jobController, LandingController $landingController)
    {
        $this->jobController = $jobController;
        $this->landingController = $landingController;
    }

    /**
     * Display the main landing page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return $this->landingController->index();
    }

    /**
     * Display the jobs list page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function jobs(): View
    {
        return $this->jobController->index();
    }

    /**
     * Display a specific job details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function jobDetails($id): View
    {
        return $this->jobController->show($id);
    }
}
