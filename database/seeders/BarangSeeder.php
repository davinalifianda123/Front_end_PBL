<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\BarangImport;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::create([
            'nama_barang' => 'Barang A',
            'id_kategori_barang' => 1,
        ]);

        $this->command->info('Importing barang from Excel...');

        $disk = 'local';
        $fileName = 'Barang.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new BarangImport, $filePath);
    }
}
