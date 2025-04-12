<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Content\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Top 10 Interview Tips for 2024',
                'description' => 'Learn the most effective interview strategies to land your dream job in the current market.',
                'image' => 'images/seeder/resume-review.jpg',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Remote Work: The Future of Employment',
                'description' => 'Explore how remote work is reshaping the job market and what it means for job seekers.',
                'image' => 'images/seeder/resume-review.jpg',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Building a Strong Professional Network',
                'description' => 'Discover proven strategies to build and maintain valuable professional connections.',
                'image' => 'images/seeder/resume-review.jpg',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blogs')->insert($blogs);
    }
}
