<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
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
                ]);
            }
        }
    }
}
