<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\MyApplications\IndexController;
use App\Http\Controllers\Applicant\MyApplications\ApplyController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MyApplicationsController extends Controller
{
    protected $indexController;
    protected $applyController;

    public function __construct(
        IndexController $indexController,
        ApplyController $applyController
    ) {
        $this->indexController = $indexController;
        $this->applyController = $applyController;
    }

    /**
     * Display a listing of the user's job applications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->indexController->__invoke();
    }

    /**
     * Apply for a job
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $job)
    {
        return $this->applyController->__invoke($request, $job);
    }
}
