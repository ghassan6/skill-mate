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

        $categories = Category::all();

        foreach(range(1 , 2) as $round) {

            foreach($categories as $category) {

                $isOffer = $faker->boolean; // generate random boolean

                $title = $isOffer

                    ? "Professional $category->name"
                    : "Need Help With $category->name";


                $description = $isOffer
                    ? "Offering expert-level $category->name with guaranteed satisfaction and affordable rates. $faker->sentence()"
                    : "Looking for someone experienced in $category->name to assist with my current needs. $faker->sentence()";


                Service::create([
                    'user_id' => $faker->numberBetween(2 , 5),
                    'category_id' => $category->id,
                    'title' => $title,
                    'description' => $description,
                    'type' => $isOffer ? 'offer' : 'request',
                    'status' => rand(0 , 1) ? 'pending' : 'completed',
                    'min_price' => $isOffer ? null : $faker->numberBetween(5, 15),
                    'max_price' => $isOffer ? null : $faker->numberBetween(20 , 35),
                    'hourly_rate' => $isOffer ? $faker->numberBetween(10 , 20) : null,
                    'city_id' => $faker->numberBetween(1 , City::max('id')),
                    'address' => fake()->address(),
                    'views' => $faker->numberBetween(0 , 100),
                    'slug'=> Str::slug($title),
                ]);
            }
        }

        Service::create([
            'user_id' => 3,
            'category_id' => 1,
            'title' => ' Fast & Affordable Fixes for your House',
            'description' => 'Need quick and professional help around the house? Our expert home repair technicians are here to tackle everything from leaky faucets and electrical issues to drywall repair and general maintenance. Serving your local area with same-day or next-day availability, we offer fair pricing, quality workmanship, and peace of mind. No job is too small – we fix it all!',
            'type' => 'offer',
            'status' => null,
            'min_price' => null,
            'max_price' => null,
            'hourly_rate' => 20,
            'city_id' => 1,
            'address' => fake()->address(),
            'views' => 0,
        ]);
    }
}
