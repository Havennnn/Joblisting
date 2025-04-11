<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Users\User;
use App\Models\Users\Employer;

class FixEmployerRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:employer-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates employer records for users that have role=employer but no entry in the employers table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding employer users without employer records...');

        // Get users who are employers but don't have records in the employers table
        $employerUsers = User::where('role', 'employer')
            ->whereDoesntHave('employer')
            ->get();

        $count = $employerUsers->count();

        if ($count === 0) {
            $this->info('No employer users without employer records found.');
            return;
        }

        $this->info("Found {$count} employer users without employer records.");

        // Create employer records for each user
        foreach ($employerUsers as $user) {
            $this->info("Creating employer record for user ID: {$user->id}, Name: {$user->name}, Email: {$user->email}");

            // Create a default employer record
            $employer = new Employer([
                'company_name' => $user->name . "'s Company", // Use the user's name as a placeholder
                'company_description' => 'Default company description. Please update with actual company information.'
            ]);

            $user->employer()->save($employer);

            $this->info("Created employer record for {$user->name}.");
        }

        $this->info('Successfully created employer records for all employer users.');
    }
}
