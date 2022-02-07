<?php

namespace Database\Seeders;

use App\Models\Meet;
use App\Models\Room;
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
            Meet::create(['name' => $faker->name ]);
            Room::create([
                'meet_id' => $faker->numberBetween(1, 10),
                'room_name' => $faker->randomElement(['room 1', 'room 2', 'room 3']),
                'meet_date' => $faker->date(),
                'start' => $faker->dateTime,
                'end' => $faker->dateTime,
            ]);
        }
    }
}
