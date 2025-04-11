<?php

namespace App\Http\Controllers\Auth\Otp;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ShowRegisterFormController extends Controller
{
    /**
     * Show the registration form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(): View
    {
        return view('auth.register');
    }
}
