<?php

namespace App\Http\Controllers\Applicant\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadResumeController extends Controller
{
    /**
     * Securely download resume from private storage
     *
     * @param \App\Models\User $user
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(User $user)
    {
        // Security check - only allow downloading own resume or admin access
        if (Auth::id() !== $user->id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        // Check if user has profile and resume
        if (!$user->applicantProfile || !$user->applicantProfile->resume_path) {
            abort(404, 'Resume not found');
        }

        // Get the resume path
        $path = $user->applicantProfile->resume_path;

        // Check if file exists
        if (!Storage::exists($path)) {
            abort(404, 'Resume not found');
        }

        // Return the file as a download
        return Storage::download($path, 'resume.pdf');
    }
}
