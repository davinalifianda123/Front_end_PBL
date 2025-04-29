<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CabangKePusat;
use Illuminate\Database\Seeder;

class CabangKePusatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CabangKePusat::create([
            'kode' => 'abc',
            'id_pusat' => 1,
            'id_cabang' => 1,
            'id_barang' => 1,
            'jumlah' => 10,
            'tanggal' => now(),
        ]);
    }
}
