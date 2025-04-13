<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriBarang::create(['nama_kategori' => 'Beras']);
        KategoriBarang::create(['nama_kategori' => 'Minyak Goreng']);
        KategoriBarang::create(['nama_kategori' => 'Gula Pasir']);
        KategoriBarang::create(['nama_kategori' => 'Telur']);
        KategoriBarang::create(['nama_kategori' => 'Tepung Terigu']);
    }
}
