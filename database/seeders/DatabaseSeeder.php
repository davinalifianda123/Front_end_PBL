<?php

namespace Database\Seeders;

use App\Models\CabangKePusat;
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
            GudangDanTokoSeeder::class,
            UserSeeder::class,
            KategoriBarangSeeder::class,
            BarangSeeder::class,
            KurirSeeder::class,
            StatusPengirimanBarangSeeder::class,
            StatusReturSeeder::class,
            JenisPenerimaanSeeder::class,
            CabangKePusatSeeder::class,
        ]);
    }
}
