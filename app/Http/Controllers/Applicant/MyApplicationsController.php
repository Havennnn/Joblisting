<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\MyApplications\IndexController;
use App\Http\Controllers\Applicant\MyApplications\StoreController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MyApplicationsController extends Controller
{
    protected $indexController;
    protected $storeController;

    public function __construct(
        IndexController $indexController,
        StoreController $storeController
    ) {
        $this->indexController = $indexController;
        $this->storeController = $storeController;
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
     * Store a new job application
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $job)
    {
        return $this->storeController->__invoke($request, $job);
    }
}
