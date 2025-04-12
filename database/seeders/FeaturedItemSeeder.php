<?php

namespace Database\Seeders;

use App\Models\Content\FeaturedItem;
use Illuminate\Database\Seeder;

class FeaturedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featuredItems = [
            [
                'title' => 'Find Your Dream Job Today',
                'subtitle' => 'Join thousands of successful professionals',
                'imagePath' => 'images/seeder/banner1.png',
                'button_text' => 'Browse Jobs',
                'button_link' => '/jobs',
                'is_active' => true,
                'order' => 1
            ],
            [
                'title' => 'Virtual Job Fair',
                'subtitle' => 'Connect with top employers online',
                'imagePath' => 'images/seeder/banner2.png',
                'button_text' => 'Learn More',
                'button_link' => '/events',
                'is_active' => true,
                'order' => 2
            ],
            [
                'title' => 'Career Development',
                'subtitle' => 'Enhance your skills and grow',
                'imagePath' => 'images/seeder/banner3.png',
                'button_text' => 'Get Started',
                'button_link' => '/resources',
                'is_active' => true,
                'order' => 3
            ]
        ];

        foreach ($featuredItems as $item) {
            FeaturedItem::create($item);
        }
    }
}
