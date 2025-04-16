<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\Kurir;
use App\Models\Barang;
use App\Models\Gudang;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\PengirimanBarang;
use App\Models\DetailPengirimanBarang;
use App\Models\StatusPengirimanBarang;

class PengirimanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $gudangs = Gudang::all();
        $kurirs = Kurir::all();
        $tokos = Toko::all();
        $barangs = Barang::alL();
        $status = StatusPengirimanBarang::all();

        for ($i = 0; $i < 5; ++$i) {
            $pengirimanBarang = PengirimanBarang::create([
                'id_gudang' => $gudangs->random()->id,
                'tanggal_pengiriman' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'id_status_pengiriman' => $status->random()->id,
                'id_kurir' => $kurirs->random()->id,
                'id_toko' => $tokos->random()->id,
            ]);

            $jumlahDetail = rand(1, 3);
            for ($j = 0; $j < $jumlahDetail; ++$j) {
                $barang = $barangs->random();
                $jumlahBarang = rand(1, 10);
                $barangYangDikirim = min($barang->jumlah_stok, $jumlahBarang);
                
                DetailPengirimanBarang::create([
                    'id_barang' => $barang->id,
                    'id_pengiriman_barang' => $pengirimanBarang->id,
                    'jumlah' => $barangYangDikirim,
                ]);
                
                $barang->jumlah_stok -= $barangYangDikirim;
                $barang->save();
            }
        }
    }
}
