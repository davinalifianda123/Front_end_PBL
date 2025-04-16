<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ReturBarang;
use App\Models\StatusRetur;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\PengirimanBarang;
use App\Models\DetailReturBarang;
use App\Models\DetailPengirimanBarang;

class ReturBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $users = User::all();
        $statusRetur = StatusRetur::all();
        $pengirimanBarangs = PengirimanBarang::where('id_status_pengiriman', 3)->get();

        if ($pengirimanBarangs->count() > 0) {
            foreach ($pengirimanBarangs as $pengirimanBarang) {
                $returBarang = ReturBarang::create([
                    'id_user' => $users->random()->id,
                    'tanggal_retur' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                    'alasan_retur' => $faker->sentence,
                    'id_status_retur' => $statusRetur->random()->id,
                    'id_pengiriman_barang' => $pengirimanBarang->id,
                ]);

                $detailPengirimanBarangs = DetailPengirimanBarang::where('id_pengiriman_barang', $pengirimanBarang->id)->get();

                if ($detailPengirimanBarangs->count() > 0) {
                    $jumlahDetail = rand(1, min(3, $detailPengirimanBarangs->count()));
                    $barangYangDikirim = $detailPengirimanBarangs->random($jumlahDetail);

                    foreach ($barangYangDikirim as $detailPengirimanBarang) {
                        DetailReturBarang::create([
                            'id_retur' => $returBarang->id,
                            'id_barang' => $detailPengirimanBarang->id_barang,
                            'jumlah_barang_retur' => rand(1, $detailPengirimanBarang->jumlah),
                        ]);
                    }
                }
            }
        }
    }
}
