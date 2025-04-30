<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PusatKeCabang;
class PusatKeCabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PusatKeCabang::create([
            'kode'=> '1',
            'id_pusat'=> 1,
            'id_cabang'=> 1,
            'id_barang'=> 1,
            'jumlah'=> 20,
            'tanggal'=> now(),
        ]);
    }
}
