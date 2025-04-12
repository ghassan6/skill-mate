<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Home Repair', 'slug' => 'home-repair', 'image' => 'images/categories/home-repair.jpg'],
            ['name' => 'Electrical Services', 'slug' => 'electrical-services', 'image' => 'images/categories/electrical-services.jpg'],
            ['name' => 'Car Maintenance', 'slug' => 'car-maintenance', 'image' => 'images/categories/car-maintenance.jpg'],
            ['name' => 'Mobile and Tablet Repair Services', 'slug' => 'mobile-and-tablet-repair-services', 'image' => 'images/categories/mobile-and-tablet-repair-services.jpg'],
            ['name' => 'Computer and Laptop Repair Services', 'slug' => 'computer-and-laptop-repair-services', 'image' => 'images/categories/computer-and-laptop-repair-services.jpg'],
            ['name' => 'Moving Services', 'slug' => 'moving-services', 'image' => 'images/categories/moving-services.jpg'],
            ['name' => 'Medical Services', 'slug' => 'medical-services', 'image' => 'images/categories/medical-services.jpg'],
            ['name' => 'Legal Services', 'slug' => 'legal-services', 'image' => 'images/categories/legal-services.jpg'],
            ['name' => 'Events Services', 'slug' => 'events-services', 'image' => 'images/categories/events-services.jpg'],
            ['name' => 'Towing Services', 'slug' => 'towing-services', 'image' => 'images/categories/towing-services.jpg'],
            ['name' => 'Home Cleaning Services', 'slug' => 'home-cleaning-services', 'image' => 'images/categories/home-cleaning-services.jpg'],
            ['name' => 'Gardening Services', 'slug' => 'gardening-services', 'image' => 'images/categories/gardening-services.jpg'],
            ['name' => 'Water Tanks Services', 'slug' => 'water-tanks-services', 'image' => 'images/categories/water-tanks-services.jpg'],
            ['name' => 'Pest Control Services', 'slug' => 'pest-control-services', 'image' => 'images/categories/pest-control-services.jpg'],
            ['name' => 'Photography Services', 'slug' => 'photography-services', 'image' => 'images/categories/photography-services.jpg'],
            ['name' => 'Beauty Services', 'slug' => 'beauty-services', 'image' => 'images/categories/beauty-services.jpg'],
            ['name' => 'Fitness Services', 'slug' => 'fitness-services', 'image' => 'images/categories/fitness-services.jpg'],
            ['name' => 'Education Services', 'slug' => 'education-services', 'image' => 'images/categories/education-services.jpg'],
            ['name' => 'Transport Services', 'slug' => 'transport-services', 'image' => 'images/categories/transport-services.jpg'],
            ['name' => 'Travel Services', 'slug' => 'travel-services', 'image' => 'images/categories/travel-services.jpg'],
            ['name' => 'other', 'slug' => 'other', 'image' => 'images/categories/other.jpg'],

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
