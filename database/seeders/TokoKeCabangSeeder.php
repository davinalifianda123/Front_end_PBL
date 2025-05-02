<?php

namespace Database\Seeders;

use App\Models\TokoKeCabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokoKeCabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TokoKeCabang::create([
            'kode' => 'TKC001',
            'id_toko' => 1,
            'id_cabang' => 1,
            'id_barang' => 1,
            'jumlah' => 10,
            'tanggal' => now(),
        ]);
    }
}
