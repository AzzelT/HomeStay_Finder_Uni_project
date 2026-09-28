<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Province;
use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Roles ──────────────────────────────────────────────────────────
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        // ── 2. Admin User ─────────────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@homestayfinder.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // ── 3. Provinces ──────────────────────────────────────────────────────
        $provinces = [
            'Phnom Penh',
            'Siem Reap',
            'Sihanoukville',
            'Kampot',
            'Battambang',
            'Kep',
            'Mondulkiri',
            'Ratanakiri',
            'Kandal',
            'Takeo',
            'Kompong Cham',
            'Kratie',
        ];

        foreach ($provinces as $name) {
            Province::firstOrCreate(['name' => $name]);
        }

        // ── 4. Amenities ──────────────────────────────────────────────────────
        $amenities = [
            'Free WiFi',
            'Swimming Pool',
            'Free Parking',
            'Air Conditioning',
            'Restaurant',
            'Room Service',
            'Airport Shuttle',
            'Gym',
            'Spa',
            'Bar',
            'Breakfast Included',
            'Pet Friendly',
        ];

        foreach ($amenities as $name) {
            Amenity::firstOrCreate(['name' => $name]);
        }
    }
}
