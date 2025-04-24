<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use App\Models\Users\Employer;
use App\Models\Companies\Company;
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
            'phone_number' => '1234567890',
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

        // Create test company
        $company = Company::create([
            'name' => 'Nextjob',
            'industry' => 'Information Technology',
            'description' => 'A test company for development purposes',
            'location' => 'Manila, Philippines',
            'is_verified' => true,
        ]);

        // Create employer profile with company association
        $employer->employer()->create([
            'phone_number' => '9876543210',
            'setup_completed' => true,
            'company_id' => $company->id,
        ]);

        $this->command->info('Test users created successfully:');
        $this->command->info('Applicant: applicant@test.com / password');
        $this->command->info('Employer: employer@test.com / password');
    }
}
