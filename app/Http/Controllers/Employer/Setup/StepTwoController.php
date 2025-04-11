<?php

namespace App\Http\Controllers\Employer\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StepTwoController extends Controller
{
    /**
     * Process step 2 (Company Information)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'required|string',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Remove 'company_logo' from validated array since we can't store the file object in session
        if (isset($validated['company_logo'])) {
            unset($validated['company_logo']);
        }

        // Process company logo if uploaded
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $path = $file->store('company-logos', 'public');

            // Verify the file was stored successfully
            if (Storage::disk('public')->exists($path)) {
                // Log logo upload success to help with debugging
                Log::info('Company logo uploaded', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'stored_path' => $path,
                    'exists_in_storage' => Storage::disk('public')->exists($path),
                    'full_url' => asset('storage/' . $path)
                ]);

                $validated['company_logo_path'] = $path;
            } else {
                Log::error('Failed to store company logo', [
                    'original_name' => $file->getClientOriginalName()
                ]);
            }
        }

        // Store data in session
        Session::put('setup_data', array_merge(Session::get('setup_data', []), $validated));
        Session::put('setup_step', 3);

        return redirect()->route('employer.setup');
    }
}
