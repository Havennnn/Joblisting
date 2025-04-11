<?php

namespace App\Http\Controllers\Settings\ChangeEmail;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ShowFormController extends Controller
{
    /**
     * Show the email change form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('settings.email-change-form');
    }
}
