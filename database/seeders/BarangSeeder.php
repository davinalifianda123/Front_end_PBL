<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('barangs')->insert([
            [
                
                'nama_barang' => 'Barang 1',
                'id_kategori' => 1,
                'berat' => 100,
            ],
        ]);
    }
}
