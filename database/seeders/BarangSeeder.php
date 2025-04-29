<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Barang::create([
            'nama_barang' => 'Barang A',
            'id_kategori' => 1,
            'berat' => 100,
            'flag' => 1,
        ]);
    }
}
