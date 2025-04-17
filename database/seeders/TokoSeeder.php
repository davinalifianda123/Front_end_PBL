<?php

namespace Database\Seeders;

use App\Imports\TokoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing toko from Excel...');

        $disk = 'local';
        $fileName = 'Toko.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new TokoImport, $filePath);
    }
}
