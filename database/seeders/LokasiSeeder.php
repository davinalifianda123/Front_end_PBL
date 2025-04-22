<?php

namespace Database\Seeders;

use App\Imports\LokasiImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing lokasi from Excel...');

        $disk = 'local';
        $fileName = 'Lokasi.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new LokasiImport, $filePath);
    }
}
