<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplierKePusat;

class SupplierKePusatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        SupplierKePusat::create([
            'kode'=> '1525',
            'id_supplier' => 1,
            'id_pusat' => 1,
            'id_barang' => 1,
            'jumlah' => 20,
            'tanggal' => now(),
        ]);
}
}