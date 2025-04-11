<?php

namespace App\Http\Controllers\Applicant\Profile;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowProfilePictureController extends Controller
{
    /**
     * Securely serve profile picture from private storage
     *
     * @param \App\Models\Users\User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        // Security check - only allow viewing own profile picture or admin access
        if (Auth::id() !== $user->id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        // Check if user has profile and profile picture
        if (!$user->applicantProfile || !$user->applicantProfile->profile_picture_path) {
            abort(404, 'Profile picture not found');
        }

        // Get the profile picture path
        $path = $user->applicantProfile->profile_picture_path;

        // Check if file exists
        if (!Storage::exists($path)) {
            abort(404, 'Profile picture not found');
        }

        // Return the file
        $file = Storage::get($path);
        $mimeType = Storage::mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType);
    }
}
