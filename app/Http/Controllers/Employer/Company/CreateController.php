<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateController extends Controller
{
    /**
     * Display the company creation form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('employer.company.create');
    }

    /**
     * Store a newly created company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'industry' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'website' => 'nullable|url|max:255',
            'founding_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Create company record
        $company = new Company();
        $company->name = $validated['name'];
        $company->industry = $validated['industry'];
        $company->description = $validated['description'];
        $company->website = $validated['website'] ?? null;
        $company->founding_year = $validated['founding_year'] ?? null;
        $company->location = $validated['location'];
        $company->size = $validated['size'];
        $company->is_verified = false; // New companies start unverified

        // Handle company logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company-logos', 'public');
            $company->logo_path = $path;
        }

        $company->save();

        // Associate the current employer with the new company
        $employer = Auth::user()->employer;
        $employer->company_id = $company->id;
        $employer->save();

        return redirect()->route('employer.company.index')
            ->with('success', 'Company created successfully! You are now the owner of this company.');
    }
}
