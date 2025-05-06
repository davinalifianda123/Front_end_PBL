<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailGudang;

class DetailGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailGudang::create([
            'id_gudang' => 1,
            'id_barang' => 1,
            'id_satuan_berat' => 1,
            'jumlah_stok' => 100,
        ]);

        DetailGudang::create([
            'id_gudang' => 2,
            'id_barang' => 1,
            'id_satuan_berat' => 1,
            'jumlah_stok' => 50,
        ]);
    }
}
