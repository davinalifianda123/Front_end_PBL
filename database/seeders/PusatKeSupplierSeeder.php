<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PusatKeSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pusat_ke_suppliers')->insert([
            [
                'kode' => 'PUSAT001',
                'id_pusat' => 1,
                'id_supplier' => 1,
                'id_barang' => 1,
                'jumlah' => 100,
                'tanggal' => now(),
            ],
        ]);
    }
}
