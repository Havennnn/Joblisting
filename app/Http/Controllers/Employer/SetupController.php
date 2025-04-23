<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\Setup\IndexController;
use App\Http\Controllers\Employer\Setup\ProcessController;
use App\Http\Controllers\Employer\Setup\SkipController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    protected $indexController;
    protected $processController;
    protected $skipController;

    /**
     * SetupController constructor
     *
     * Injects specialized controllers using dependency injection
     */
    public function __construct(
        IndexController $indexController,
        ProcessController $processController,
        SkipController $skipController
    ) {
        $this->indexController = $indexController;
        $this->processController = $processController;
        $this->skipController = $skipController;
    }

    /**
     * Show the setup wizard
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return $this->indexController->__invoke();
    }

    /**
     * Process setup information
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processSetup(Request $request): RedirectResponse
    {
        return $this->processController->__invoke($request);
    }

    /**
     * Skip the setup process
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function skip(): RedirectResponse
    {
        return $this->skipController->__invoke();
    }
}
