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
            ['name' => 'Home Repair', 'slug' => 'home-repair'],
            ['name' => 'Electrical Services', 'slug' => 'electrical-services'],
            ['name' => 'Car Maintenance', 'slug' => 'car-maintenance'],
            ['name' => 'Mobile and Tablet Repair Services', 'slug' => 'mobile-and-tablet-repair-services'],
            ['name' => 'Computer and Laptop Repair Services', 'slug' => 'computer-and-laptop-repair-services'],
            ['name' => 'Moving Services', 'slug' => 'moving-services'],
            ['name' => 'Medical Services', 'slug' => 'medical-services'],
            ['name' => 'Legal Services', 'slug' => 'legal-services'],
            ['name' => 'Events Services', 'slug' => 'events-services'],
            ['name' => 'Towing Services', 'slug' => 'towing-services'],
            ['name' => 'Home Cleaning Services', 'slug' => 'home-cleaning-services'],
            ['name' => 'Gardening Services', 'slug' => 'gardening-services'],
            ['name' => 'Water Tanks Services', 'slug' => 'water-tanks-services'],
            ['name' => 'Pest Control Services', 'slug' => 'pest-control-services'],
            ['name' => 'Photography Services', 'slug' => 'photography-services'],
            ['name' => 'Beauty Services', 'slug' => 'beauty-services'],
            ['name' => 'Fitness Services', 'slug' => 'fitness-services'],
            ['name' => 'Education Services', 'slug' => 'education-services'],
            ['name' => 'Transport Services', 'slug' => 'transport-services'],
            ['name' => 'Travel Services', 'slug' => 'travel-services'],
            ['name' => 'other', 'slug' => 'other'],

        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
