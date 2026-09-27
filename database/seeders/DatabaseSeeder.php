<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@homestayfinder.test'],
            [
                'name' => 'Homestay Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}
