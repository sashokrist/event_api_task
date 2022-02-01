<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();
        $password = Hash::make('11111111');
        User::create([
                         'name' => 'Administrator',
                         'email' => 'admin@test.com',
                         'password' => $password,
                     ]);

        for ($i = 0; $i < 10; $i++) {
            User::create([
                             'name' => $faker->name,
                             'email' => $faker->email,
                             'password' => $password,
                         ]);
        }
    }
}
