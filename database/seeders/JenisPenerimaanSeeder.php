<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Imports\JenisPenerimaanImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class JenisPenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->command->info('Importing NamaJenisPenerimaan from Excel...');

        $disk = 'local';
        $fileName = 'NamaJenisPenerimaan.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new JenisPenerimaanImport, $filePath);
    }
}
