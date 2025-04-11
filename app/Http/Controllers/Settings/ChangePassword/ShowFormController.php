<?php

namespace App\Http\Controllers\Settings\ChangePassword;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ShowFormController extends Controller
{
    /**
     * Show the password change form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('settings.password-change-form');
    }
}
