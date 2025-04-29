<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Interviews\Interview;
use App\Models\Jobs\JobApplication;

class UpdateInterviewApplicationIds extends Command
{
    protected $signature = 'interviews:update-application-ids';
    protected $description = 'Update existing interviews with their corresponding job application IDs';

    public function handle()
    {
        $this->info('Starting to update interview application IDs...');

        $interviews = Interview::whereNull('job_application_id')->get();
        $count = 0;

        foreach ($interviews as $interview) {
            $application = JobApplication::where('job_id', $interview->job_id)
                ->where('applicant_id', $interview->applicant_id)
                ->first();

            if ($application) {
                $interview->job_application_id = $application->id;
                $interview->save();
                $count++;
            }
        }

        $this->info("Updated {$count} interviews with job application IDs.");
    }
}
