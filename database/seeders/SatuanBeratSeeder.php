<?php

namespace Database\Seeders;

use App\Imports\SatuanBeratImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SatuanBeratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing satuan berat from Excel...');

        $disk = 'local';
        $fileName = 'SatuanBerat.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new SatuanBeratImport, $filePath);
    }
}
