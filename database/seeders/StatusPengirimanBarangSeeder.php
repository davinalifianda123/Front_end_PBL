<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusPengirimanBarang;

class StatusPengirimanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusPengirimanBarang::create(['nama_status' => 'Pending']);
        StatusPengirimanBarang::create(['nama_status' => 'Dikirim']);
        StatusPengirimanBarang::create(['nama_status' => 'Selesai']);
    }
}
