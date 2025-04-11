<?php

namespace App\Console\Commands;

use App\Models\Jobs\JobApplication;
use App\Models\Jobs\JobPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateJobApplicationCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-job-application-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update application_count and unread_application_count for all job posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating job application counts...');

        // Get all job posts
        $jobPosts = JobPost::all();
        $count = 0;

        foreach ($jobPosts as $jobPost) {
            // Get all applications for this job
            $totalApplications = JobApplication::where('job_id', $jobPost->id)->count();

            // Get unread applications count
            $unreadApplications = JobApplication::where('job_id', $jobPost->id)
                ->whereNull('viewed_at')
                ->count();

            // Update the job post
            DB::transaction(function () use ($jobPost, $totalApplications, $unreadApplications) {
                $jobPost->application_count = $totalApplications;
                $jobPost->unread_application_count = $unreadApplications;
                $jobPost->save();
            });

            $count++;
        }

        $this->info("Updated application counts for {$count} job posts.");
    }
}
