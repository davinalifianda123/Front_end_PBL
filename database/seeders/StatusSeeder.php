<?php

namespace Database\Seeders;

use App\Imports\StatusImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $this->command->info('Importing status from Excel...');

        $disk = 'local';
        $fileName = 'Status.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new StatusImport, $filePath);
    }
}
