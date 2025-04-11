<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreviousStepController extends Controller
{
    /**
     * Go back to previous step
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $currentStep = Session::get('setup_step', 1);

        if ($currentStep > 1) {
            Session::put('setup_step', $currentStep - 1);
        }

        return redirect()->route('employer.setup');
    }
}
