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
        // Register custom relationship morphMap keys
        Relation::morphMap([
            'user' => \App\Models\User::class,
            'employer' => \App\Models\Users\Employer::class,
            'jobseeker' => \App\Models\Users\Jobseeker::class,
            'jobpost' => \App\Models\Jobs\JobPost::class,
            'company' => \App\Models\Company::class,
            'company_invitation' => \App\Models\Company\CompanyInvitation::class,
            'job_application' => \App\Models\Jobs\JobApplication::class,
            'interview' => \App\Models\Jobs\Interview::class,
            'notification' => \App\Models\Notification::class,
            'saved_job' => \App\Models\Jobs\SavedJob::class,
        ]);
    }
}
