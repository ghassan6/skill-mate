<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'amman',
            'zarqa',
            'irbid',
            'aqaba',
            'mafraq',
            'madaba',
            'ramtha',
            'salt',
            'tafila',
            'karak',
            'jerash',
            'ajloun',
            'maan',
            'sahab',
        ];

        foreach ($cities as $city) {
            City::create(['name' => $city]);
        }
    }
}
