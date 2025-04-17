<?php

namespace Database\Seeders;

use App\Imports\GudangImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing gudang from Excel...');

        $disk = 'local';
        $fileName = 'Gudang.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new GudangImport, $filePath);
    }
}
