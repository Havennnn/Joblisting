<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find an employer user
        $employer = DB::table('users')
            ->where('role', 'employer')
            ->join('employers', 'users.id', '=', 'employers.user_id')
            ->select('employers.id')
            ->first();

        if (!$employer) {
            $this->command->error('No employer user found. Please create an employer user first.');
            return;
        }

        $employer_id = $employer->id;

        $jobPosts = [];

        // Sample data arrays
        $jobTitles = [
            'Software Developer', 'Marketing Specialist', 'Customer Service Representative',
            'Sales Manager', 'Data Analyst', 'UX/UI Designer', 'Project Manager',
            'Content Writer', 'HR Specialist', 'Financial Analyst', 'Product Manager',
            'Graphic Designer', 'DevOps Engineer', 'Business Analyst', 'Quality Assurance Engineer',
            'IT Support Specialist', 'Network Administrator', 'Database Administrator',
            'Full Stack Developer', 'Front-end Developer'
        ];

        $industries = [
            'Information Technology', 'Marketing', 'Customer Service', 'Sales',
            'Data Science', 'Design', 'Management', 'Content Creation',
            'Human Resources', 'Finance', 'Healthcare', 'Education',
            'Engineering', 'Media', 'Retail', 'Manufacturing',
            'Hospitality', 'Legal', 'Construction', 'Telecommunications'
        ];

        $locations = [
            'Manila, Philippines', 'Cebu, Philippines', 'Davao, Philippines',
            'Makati, Philippines', 'Quezon City, Philippines', 'Taguig, Philippines',
            'Pasig, Philippines', 'Mandaluyong, Philippines', 'Pasay, Philippines',
            'Paranaque, Philippines'
        ];

        $workSetups = ['Remote', 'Hybrid', 'On-site'];
        $types = ['Full-time', 'Part-time', 'Contract', 'Internship'];
        $experienceLevels = ['Entry Level', 'Mid Level', 'Senior Level'];
        $educationalLevels = ['High School', 'Bachelor\'s Degree', 'Master\'s Degree', 'PhD'];
        $shifts = ['Day Shift', 'Night Shift', 'Flexible Hours'];
        $tags = ['Featured', 'Urgent', 'Regular'];

        // Create 20 job posts
        for ($i = 0; $i < 20; $i++) {
            $jobTitle = $jobTitles[$i % count($jobTitles)];
            $industry = $industries[$i % count($industries)];

            $jobPosts[] = [
                'employer_id' => $employer_id,
                'title' => $jobTitle,
                'job_description' => "We are looking for a talented $jobTitle to join our team. This position requires excellent skills in $industry and the ability to work in a fast-paced environment. The ideal candidate will have strong communication skills and be detail-oriented.",
                'location' => $locations[$i % count($locations)],
                'type' => $types[$i % count($types)],
                'work_setup' => $workSetups[$i % count($workSetups)],
                'industry' => $industry,
                'role' => $jobTitle,
                'salary' => rand(20000, 100000),
                'vacancies' => rand(1, 5),
                'work_experience_level' => $experienceLevels[$i % count($experienceLevels)],
                'educational_level' => $educationalLevels[$i % count($educationalLevels)],
                'shift' => $shifts[$i % count($shifts)],
                'tags' => $tags[$i % count($tags)],
                'created_at' => Carbon::now()->subDays($i),
                'updated_at' => Carbon::now(),
                'auto_delete_at' => Carbon::now()->addDays(30),
            ];
        }

        DB::table('jobposts')->insert($jobPosts);

        $this->command->info('20 job posts created successfully for employer ID: ' . $employer_id);
    }
}
