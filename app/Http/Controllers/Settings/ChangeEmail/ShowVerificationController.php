<?php

namespace App\Http\Controllers\Settings\ChangeEmail;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ShowVerificationController extends Controller
{
    /**
     * Show OTP verification page for email change
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $newEmail = session('pending_email_change');

        if (!$newEmail) {
            return redirect()->route('settings.index')
                ->with('error', 'Email change request expired. Please try again.');
        }

        return view('settings.verify-email-change', ['email' => $newEmail]);
    }
}
