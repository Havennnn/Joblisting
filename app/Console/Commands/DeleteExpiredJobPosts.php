<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jobs\JobPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteExpiredJobPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-job-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete job posts that have passed their auto-delete date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $expiredJobs = JobPost::where('auto_delete_at', '<', $now)->get();

        $count = $expiredJobs->count();

        if ($count > 0) {
            foreach ($expiredJobs as $job) {
                $this->info("Deleting expired job: {$job->title} (ID: {$job->id})");
                Log::info("Auto-deleting expired job: {$job->title} (ID: {$job->id})");
                $job->delete();
            }

            $this->info("Successfully deleted {$count} expired job posts.");
            Log::info("Deleted {$count} expired job posts via scheduled command.");
        } else {
            $this->info("No expired job posts found.");
            Log::info("No expired job posts found during scheduled deletion check.");
        }

        return 0;
    }
}
