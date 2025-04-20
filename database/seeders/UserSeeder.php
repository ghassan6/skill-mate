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
                'phone_number' => '0785479999',
            ],
            [
                'username' => 'user',
                'first_name' => 'user',
                'last_name' => 'user',
                'email' => 'user@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,
                'phone_number' => '0785545697',


            ],
            [
                'username' => 'john doe',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'jon@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 1,
                'phone_number' => '0795478852',


            ],
            [
                'username' => 'jane smith',
                'first_name' => 'Jane',
                'last_name' => 'smith',
                'email' => 'jane@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 2,
                'phone_number' => '0795475521',


            ],
            [
                'username' => 'bob brown',
                'first_name' => 'Bob',
                'last_name' => 'Brown',
                'email' => 'bob@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 2,
                'phone_number' => '0785459963',

            ],
            [
                'username' => 'alice green',
                'first_name' => 'Alice',
                'last_name' => 'Green',
                'email' => 'alice@ex.com',
                'password' => bcrypt('qwerty'),
                'role' => 'user',
                'city_id' => 3,
                'phone_number' => '0785478852',
            ],


        ];

        foreach ($users as $user) {
            User::create($user);
        }

    }
}
