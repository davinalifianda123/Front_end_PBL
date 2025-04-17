<?php

namespace Database\Seeders;

use App\Imports\RolesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing roles from Excel...');

        $disk = 'local';
        $fileName = 'Roles.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new RolesImport, $filePath);
    }
}
