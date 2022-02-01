<?php

namespace Database\Seeders;

use App\Models\Meet;
use Illuminate\Database\Seeder;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meet::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Meet::create([
                             'name' => $faker->name,
                             'room' => $faker->randomElement(['room 1', 'room 2', 'room 3']),
                            'start_time' => $faker->dateTime,
                            'end_time' => $faker->dateTime,
                         ]);
        }
    }
}
