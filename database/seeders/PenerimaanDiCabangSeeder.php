<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenerimaanDiCabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenerimaanDiCabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenerimaanDiCabang::create([
            'id_jenis_penerimaan' => 1,
            'id_asal_barang' => 1,
            'id_barang' => 1,
            'jumlah' => 10,
            'tanggal' => now(),
        ]);

        PenerimaanDiCabang::create([
            'id_jenis_penerimaan' => 1,
            'id_asal_barang' => 1,
            'id_barang' => 1,
            'jumlah' => 20,
            'tanggal' => now(),
        ]);
    }
}
