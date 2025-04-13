<?php

namespace Database\Seeders;

use App\Models\DetailPenerimaanBarang;
use App\Models\KategoriBarang;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Supplier;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\PenerimaanBarang;

class PenerimaanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $suppliers = Supplier::all();
        $gudangs = Gudang::all();

        for ($i = 0; $i < 5; ++$i) {
            $penerimaanBarang = PenerimaanBarang::create([
                'id_supplier' => $suppliers->random()->id,
                'id_gudang' => $gudangs->random()->id,
                'tanggal_penerimaan' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d H:i:s')
            ]);

            $jumlahDetail = rand(1, 3);
            for ($j = 0; $j < $jumlahDetail; ++$j) {
                $namaBarang = $faker->word;
                $jumlahBarang = rand(10, 30);

                $barang = Barang::where('nama_barang', $namaBarang)->first();

                if ($barang) {
                    DetailPenerimaanBarang::create([
                        'id_penerimaan_barang' => $penerimaanBarang->id,
                        'id_barang' => $barang->id,
                        'jumlah' => $jumlahBarang,
                        'status' => 'Barang Lama',
                    ]);

                    $barang->jumlah_stok += $jumlahBarang;
                    $barang->save();
                } else {
                    $categories = KategoriBarang::all();

                    $barangBaru = Barang::create([
                        'nama_barang' => $namaBarang,
                        'id_kategori' => $categories->random()->id,
                        'id_gudang' => $penerimaanBarang->id_gudang,
                        'jumlah_stok' => $jumlahBarang,
                        'berat' => rand(1, 10),
                        'harga_jual' => rand(1000, 10000), 
                        'harga_beli' => rand(500, 5000),
                    ]);

                    DetailPenerimaanBarang::create([
                        'id_penerimaan_barang' => $penerimaanBarang->id,
                        'id_barang' => $barangBaru->id,
                        'jumlah' => $jumlahBarang,
                        'status' => 'Barang Baru',
                    ]);
                }
            }
        }
    }
}
