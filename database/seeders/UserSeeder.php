<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'username' => 'admin',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'admin',
                'city_id' => 1,
            ],
            [
                'username' => 'user',
                'first_name' => 'user',
                'last_name' => 'user',
                'email' => 'user@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,

            ],
            [
                'username' => 'john_doe',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'jon@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,

            ],
            [
                'username' => 'jane_smith',
                'first_name' => 'Jane',
                'last_name' => 'smith',
                'email' => 'jane@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,

            ],
            [
                'username' => 'bob_brown',
                'first_name' => 'Bob',
                'last_name' => 'Brown',
                'email' => 'bob@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,
            ]

        ];

        foreach ($users as $user) {
            User::create($user);
        }
  
    }
}
