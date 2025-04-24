<?php

namespace App\Console\Commands;

use App\Models\Companies\CompanyInvitation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireOldInvitations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitations:expire {--days=7 : Number of days after which invitations expire}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire old company invitations that have not been accepted or declined';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Finding invitations older than {$days} days...");

        $count = CompanyInvitation::where('status', 'pending')
            ->where('created_at', '<', $cutoffDate)
            ->update(['status' => 'expired']);

        $this->info("Expired {$count} old invitation(s).");

        return 0;
    }
}
