<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PusatKeSupplier;
class PusatKeSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PusatKeSupplier::create([
            'kode' => 'PUSAT001',
            'id_pusat' => 1,
            'id_supplier' => 1,
            'id_barang' => 1,
            'jumlah' => 100,
            'tanggal' => now(),
    ]);

        PusatKeSupplier::create([
                'kode' => 'PUSAT002',
                'id_pusat' => 1,
                'id_supplier' => 2,
                'id_barang' => 2,
                'jumlah' => 200,
                'tanggal' => now(),
        ]);
    }
}
