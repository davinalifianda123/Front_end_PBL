<?php

namespace Database\Seeders;

use App\Imports\StatusPengirimanBarangImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StatusPengirimanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing status pengiriman barang from Excel...');

        $disk = 'local';
        $fileName = 'StatusPengirimanBarang.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new StatusPengirimanBarangImport, $filePath);
    }
}
