<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // No aliases needed as they reference non-existent classes
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'user' => \App\Models\Users\User::class,
            'employer' => \App\Models\Users\Employer::class,
            'jobseeker' => \App\Models\Users\ApplicantProfile::class,
            'jobpost' => \App\Models\Jobs\JobPost::class,
            'company' => \App\Models\Companies\Company::class,
            'company_invitation' => \App\Models\Companies\CompanyInvitation::class,
            'job_application' => \App\Models\Jobs\JobApplication::class,
            'interview' => \App\Models\Interviews\Interview::class,
            'saved_job' => \App\Models\Jobs\SavedJob::class,
        ]);
    }
}
