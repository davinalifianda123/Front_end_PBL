<?php

namespace Database\Seeders;

use App\Models\StatusRetur;
use Illuminate\Database\Seeder;

class StatusReturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusRetur::create(['nama_status' => 'Pending']);
        StatusRetur::create(['nama_status' => 'Diproses']);
        StatusRetur::create(['nama_status' => 'Selesai']);
    }
}
