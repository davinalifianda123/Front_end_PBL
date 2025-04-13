<?php

namespace Database\Seeders;

use App\Models\Kurir;
use Faker\Factory as Faker; 
use Illuminate\Database\Seeder;

class KurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            Kurir::create([
                'nama_kurir' => $faker->name,
            ]);
        }
    }
}
