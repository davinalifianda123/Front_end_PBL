<?php

namespace Database\Seeders;

use App\Imports\UsersImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Importing users from Excel...');

        $disk = 'local';
        $fileName = 'Users.xlsx';
        $filePath = Storage::disk($disk)->path($fileName);

        Excel::import(new UsersImport, $filePath);
    }
}
