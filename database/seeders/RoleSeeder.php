<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['nama_role' => 'admin']);
        Role::create(['nama_role' => 'supervisor']);
        Role::create(['nama_role' => 'staff']);
    }
}
