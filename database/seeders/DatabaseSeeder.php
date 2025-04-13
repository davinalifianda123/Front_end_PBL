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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TokoSeeder::class,
            GudangSeeder::class,
            SupplierSeeder::class,
            KategoriBarangSeeder::class,
            KurirSeeder::class,
            // StatusPengirimanBarangSeeder::class,
            // StatusReturSeeder::class,
            // PenerimaanBarangSeeder::class,
            // PengirimanBarangSeeder::class,
            // ReturBarangSeeder::class,
        ]);
    }
}
