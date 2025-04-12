<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceImage;

class ServiceImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all()->pluck('id');

        foreach($services as $service) {
            ServiceImage::create([
                'service_id' => $service,
                'image' => 'images/services/service-default.png',
            ]);
        }

        ServiceImage::insert([
            [
            'service_id' => 43,
            'image' => 'images/services/serviceCard.jpg',
            ],
            [
            'service_id' => 43,
            'image' => 'images/services/service2.jpg',
            ],
            [
            'service_id' => 43,
            'image' => 'images/services/service2w.jpg',
            ],
            [
            'service_id' => 43,
            'image' => 'images/services/service1.jpg',
            ],
        ]);

    }
}
