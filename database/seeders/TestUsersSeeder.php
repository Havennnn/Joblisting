<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an applicant test user
        $applicant = User::create([
            'name' => 'Applicant Test',
            'email' => 'applicant@test.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'email_verified_at' => now(),
        ]);

        // Create applicant profile
        $applicant->applicantProfile()->create([
            'full_name' => 'Applicant Test',
            'setup_completed' => false,
        ]);

        // Create an employer test user
        $employer = User::create([
            'name' => 'Employer Test',
            'email' => 'employer@test.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
            'email_verified_at' => now(),
        ]);

        // Create employer profile
        $employer->employer()->create([
            'full_name' => 'Employer Test',
            'company_name' => 'Test Company',
            'setup_completed' => false,
        ]);

        $this->command->info('Test users created successfully:');
        $this->command->info('Applicant: applicant@test.com / password');
        $this->command->info('Employer: employer@test.com / password');
    }
}
