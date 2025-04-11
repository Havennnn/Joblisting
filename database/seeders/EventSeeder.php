<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Content\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Tech Career Fair 2024',
                'description' => 'Join us for the biggest tech career fair of the year!',
                'date' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'time' => '09:00:00',
                'company' => 'TechCorp',
                'price' => 0.00,
                'image' => 'events/tech-fair.jpg',
                'followers' => 150,
                'is_promoted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Startup Networking Event',
                'description' => 'Connect with innovative startups and potential employers.',
                'date' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'time' => '14:00:00',
                'company' => 'StartupHub',
                'price' => 0.00,
                'image' => 'events/startup-networking.jpg',
                'followers' => 89,
                'is_promoted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Marketing Summit',
                'description' => 'Learn from industry experts about the latest in digital marketing.',
                'date' => Carbon::now()->addDays(60)->format('Y-m-d'),
                'time' => '10:00:00',
                'company' => 'MarketingPro',
                'price' => 99.99,
                'image' => 'events/marketing-summit.jpg',
                'followers' => 234,
                'is_promoted' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Remote Work Conference',
                'description' => 'Explore opportunities in the remote work landscape.',
                'date' => Carbon::now()->addDays(75)->format('Y-m-d'),
                'time' => '11:00:00',
                'company' => 'RemoteFirst',
                'price' => 49.99,
                'image' => 'events/remote-work.jpg',
                'followers' => 178,
                'is_promoted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('events')->insert($events);
    }
}
