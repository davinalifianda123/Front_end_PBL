<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            Gudang::create([
                'nama_gudang' => 'Gudang ' . $faker->word,
                'lokasi' => $faker->address,
            ]);
        }
    }
}
