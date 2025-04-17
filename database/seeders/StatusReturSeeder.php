<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\StatusReturImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class StatusReturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing status retur from Excel...');

        $disk = 'local';
        $fileName = 'StatusRetur.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new StatusReturImport, $filePath);
    }
}
