<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PersonneSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR'); // Utilisation de Faker en français

        // Générer 50 personnes fictives
        for ($i = 0; $i < 50; $i++) {
            DB::table('personnes')->insert([
                'id' => Str::uuid(),
                'prenom' => $faker->firstName,
                'nom' => $faker->lastName,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
