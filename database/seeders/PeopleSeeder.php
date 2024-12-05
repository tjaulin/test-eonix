<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PeopleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR');

        // Generate 50 fake people
        for ($i = 0; $i < 50; $i++) {
            DB::table('people')->insert([
                'id' => Str::uuid(),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
