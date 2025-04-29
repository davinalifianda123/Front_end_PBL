<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'nama_barang' => 'Barang A',
            'id_kategori' => 1,
            'berat' => 100,
            'flag' => 1,
        ]);
    }
}
