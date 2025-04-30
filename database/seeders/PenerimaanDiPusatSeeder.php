<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenerimaanDiPusat;

class PenerimaanDiPusatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenerimaanDiPusat::create([
            'id_jenis_penerimaan' => 1,
            'id_asal_barang' => 1,
            'id_barang' => 1,
            'jumlah' => 100,
            'tanggal' => now(),
        ]);
    }
}
