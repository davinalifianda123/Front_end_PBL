<?php

namespace Database\Seeders;

use App\Models\Toko;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            Toko::create([
                'nama_toko' => 'Toko ' . $faker->word,
                'alamat' => $faker->address,
            ]);
        }
    }
}
