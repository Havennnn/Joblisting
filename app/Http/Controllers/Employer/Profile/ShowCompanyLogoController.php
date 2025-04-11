<?php

namespace App\Http\Controllers\Employer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowCompanyLogoController extends Controller
{
    /**
     * Securely serve company logo from private storage
     *
     * @param \App\Models\Users\Users\User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        // Security check - only allow viewing own company logo, the logo's company, or admin access
        if (Auth::id() !== $user->id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        // Check if user is an employer and has a company logo
        if (!$user->isEmployer() || !$user->employer || !$user->employer->company_logo_path) {
            abort(404, 'Company logo not found');
        }

        // Get the company logo path
        $path = $user->employer->company_logo_path;

        // Check if file exists
        if (!Storage::exists($path)) {
            abort(404, 'Company logo not found');
        }

        // Return the file
        $file = Storage::get($path);
        $mimeType = Storage::mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType);
    }
}
