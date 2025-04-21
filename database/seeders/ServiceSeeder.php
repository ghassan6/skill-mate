<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use Illuminate\Support\Str;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [
            'baby-sitting', 'nursing', 'Home Repair', 'Electrical Services', 'Car Maintenance',
            'Mobile and Tablet Repair Services', 'Computer and Laptop Repair Services', 'Moving Services',
            'Medical Services', 'Legal Services', 'Events Services', 'Towing Services',
            'Home Cleaning Services', 'Gardening Services', 'Water Tanks Services',
            'Pest Control Services', 'Photography Services', 'Beauty Services',
            'Fitness Services', 'Education Services', 'Transport Services',
            'Travel Services', 'other',
        ];

        foreach (range(1, 20) as $i) {
            $categoryIndex = array_rand($categories);
            $categoryName = $categories[$categoryIndex];

            Service::create([
                'user_id' => rand(2, 6),
                'category_id' => $categoryIndex + 1,
                'title' => $title = $categoryName . ' Service by ' . $faker->firstName,
                'description' => 'This ' . strtolower($categoryName) . ' service offers professional solutions. ' . $faker->paragraph,
                'hourly_rate' => $faker->randomNumber(10, 25),
                'city_id' => rand(1, 14),
                'slug' => Str::slug($title) . '-' . uniqid(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
        Service::create([
            'user_id' => 3,
            'category_id' => 3,
            'title' => ' Fast & Affordable Fixes for your House',
            'description' => 'Need quick and professional help around the house? Our expert home repair technicians are here to tackle everything from leaky faucets and electrical issues to drywall repair and general maintenance. Serving your local area with same-day or next-day availability, we offer fair pricing, quality workmanship, and peace of mind. No job is too small – we fix it all!',
            'hourly_rate' => 20,
            'city_id' => 1,
            'address' => fake()->address(),
            'views' => 0,
            'slug' => 'fast-and-affordable-fixes-for-your-house',
        ]);
    }
}

