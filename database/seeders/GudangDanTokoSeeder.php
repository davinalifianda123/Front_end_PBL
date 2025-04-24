<?php

namespace Database\Seeders;

use App\Imports\GudangDanTokoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class GudangDanTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing gudang dan toko from Excel...');

        $disk = 'local';
        $fileName = 'GudangDanToko.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new GudangDanTokoImport, $filePath);
    }
}
