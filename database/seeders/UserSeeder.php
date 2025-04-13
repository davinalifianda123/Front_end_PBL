<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('nama_role', 'admin')->first();
        $supervisorRole = Role::where('nama_role', 'supervisor')->first();
        $staffRole = Role::where('nama_role', 'staff')->first();

        $roles = [$adminRole, $supervisorRole, $staffRole];

        $faker = Faker::create();

        for ($i = 0; $i < 10; ++$i) {
            $role = $roles[$i % 3];
            User::create([
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role_id' => $role->id,
            ]);
        }
    }
}
