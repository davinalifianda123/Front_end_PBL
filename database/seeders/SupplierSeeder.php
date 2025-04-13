<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; ++$i) {
            Supplier::create([
                'nama_toko_supplier' => $faker->company,
                'alamat' => $faker->address,
                'no_telepon' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'contact_person' => $faker->name,
            ]);
        }
    }
}
