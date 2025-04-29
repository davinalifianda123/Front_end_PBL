<?php

namespace Database\Seeders;

use App\Imports\BarangImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing roles from Excel...');

        $disk = 'local';
        $fileName = 'Barang.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new BarangImport, $filePath);
    }
}
