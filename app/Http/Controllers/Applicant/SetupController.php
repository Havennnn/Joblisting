<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Applicant\Setup\IndexController;
use App\Http\Controllers\Applicant\Setup\PreviousStepController;
use App\Http\Controllers\Applicant\Setup\SkipController;
use App\Http\Controllers\Applicant\Setup\StepOneController;
use App\Http\Controllers\Applicant\Setup\StepThreeController;
use App\Http\Controllers\Applicant\Setup\StepTwoController;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    protected $indexController;
    protected $stepOneController;
    protected $stepTwoController;
    protected $stepThreeController;
    protected $previousStepController;
    protected $skipController;

    public function __construct(
        IndexController $indexController,
        StepOneController $stepOneController,
        StepTwoController $stepTwoController,
        StepThreeController $stepThreeController,
        PreviousStepController $previousStepController,
        SkipController $skipController
    ) {
        $this->indexController = $indexController;
        $this->stepOneController = $stepOneController;
        $this->stepTwoController = $stepTwoController;
        $this->stepThreeController = $stepThreeController;
        $this->previousStepController = $previousStepController;
        $this->skipController = $skipController;
    }

    /**
     * Show the setup wizard based on current step
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return $this->indexController->__invoke($request);
    }

    /**
     * Process step 1 (Basic Information)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processStepOne(Request $request)
    {
        return $this->stepOneController->__invoke($request);
    }

    /**
     * Process step 2 (Professional Information)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processStepTwo(Request $request)
    {
        return $this->stepTwoController->__invoke($request);
    }

    /**
     * Process step 3 (Confirm and Save)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processStepThree(Request $request)
    {
        return $this->stepThreeController->__invoke($request);
    }

    /**
     * Skip the setup process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function skip(Request $request)
    {
        return $this->skipController->__invoke($request);
    }

    /**
     * Go back to previous step
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function previous(Request $request)
    {
        return $this->previousStepController->__invoke($request);
    }
}
