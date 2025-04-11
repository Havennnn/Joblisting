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
            'user' => \App\Models\Users\User::class,
            'employer' => \App\Models\Users\Employer::class,
            'applicant_profile' => \App\Models\Users\ApplicantProfile::class,
            'job_post' => \App\Models\Jobs\JobPost::class,
            'job_application' => \App\Models\Jobs\JobApplication::class,
            'conversation' => \App\Models\Messaging\Conversation::class,
            'message' => \App\Models\Messaging\Message::class,
            'event' => \App\Models\Content\Event::class,
            'blog' => \App\Models\Content\Blog::class,
            'featured_item' => \App\Models\Content\FeaturedItem::class,
        ]);
    }
}
