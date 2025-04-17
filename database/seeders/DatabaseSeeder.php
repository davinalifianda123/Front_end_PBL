<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            JenisTokoSeeder::class,
            TokoSeeder::class,
            GudangSeeder::class,
            UserSeeder::class,
            KategoriBarangSeeder::class,
            KurirSeeder::class,
            StatusPengirimanBarangSeeder::class,
            StatusReturSeeder::class,
            // PenerimaanBarangSeeder::class,
            // PengirimanBarangSeeder::class,
            // ReturBarangSeeder::class,
        ]);
    }
}
