<?php

namespace Database\Seeders;

use App\Imports\JenisTokoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class JenisTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing jenis toko from Excel...');

        $disk = 'local';
        $fileName = 'JenisToko.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new JenisTokoImport, $filePath);
    }
}
