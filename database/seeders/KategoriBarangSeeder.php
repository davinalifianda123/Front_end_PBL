<?php

namespace Database\Seeders;

use App\Imports\KategoriBarangImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing kategori barang from Excel...');

        $disk = 'local';
        $fileName = 'KategoriBarang.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new KategoriBarangImport, $filePath);
    }
}
