<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Province;
use App\Models\Amenity;
use App\Models\Hotel;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin User ─────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@homestayfinder.com',
            'password' => Hash::make('password'),
        ]);

        // Assign admin role via role_user table (Panha's RBAC)
        // Make sure the 'admin' role exists first
        $adminRole = \App\Models\Role::firstOrCreate(['name' => 'admin']);
        $admin->roles()->attach($adminRole->id);

        // ── 2. Provinces ──────────────────────────────────────────────────────
        $provinces = [
            'Phnom Penh',
            'Siem Reap',
            'Sihanoukville',
            'Kampot',
            'Battambang',
            'Kep',
            'Mondulkiri',
            'Ratanakiri',
        ];

        foreach ($provinces as $name) {
            Province::create(['name' => $name]);
        }

        // ── 3. Amenities ──────────────────────────────────────────────────────
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
        ];

        foreach ($amenities as $name) {
            Amenity::create(['name' => $name]);
        }

        // ── 4. Hotels ─────────────────────────────────────────────────────────
        $hotels = [
            [
                'name'             => 'Raffles Hotel Le Royal',
                'province_id'      => 1, // Phnom Penh
                'user_id'          => $admin->id,
                'description'      => 'A legendary heritage hotel in the heart of Phnom Penh, combining colonial elegance with modern luxury. Experience world-class service and timeless Cambodian hospitality.',
                'address'          => '92 Rukhak Vithei Daun Penh, Phnom Penh',
                'price_per_night'  => 250,
                'star_rating'      => 5,
                'website_url'      => 'https://www.raffles.com/phnom-penh',
                'facebook_url'     => 'https://www.facebook.com/RafflesHotelLeRoyal',
                'google_maps_url'  => 'https://maps.google.com/?q=Raffles+Hotel+Le+Royal+Phnom+Penh',
            ],
            [
                'name'             => 'Sokha Angkor Resort',
                'province_id'      => 2, // Siem Reap
                'user_id'          => $admin->id,
                'description'      => 'Set amidst lush tropical gardens near the legendary Angkor temples, Sokha Angkor Resort offers a tranquil escape with stunning views and exceptional amenities.',
                'address'          => 'National Road No. 6, Siem Reap',
                'price_per_night'  => 180,
                'star_rating'      => 5,
                'website_url'      => 'https://www.sokhahotels.com/angkor',
                'facebook_url'     => null,
                'google_maps_url'  => 'https://maps.google.com/?q=Sokha+Angkor+Resort+Siem+Reap',
            ],
            [
                'name'             => 'Ree Hotel Sihanoukville',
                'province_id'      => 3, // Sihanoukville
                'user_id'          => $admin->id,
                'description'      => 'A beachfront boutique hotel offering stunning Gulf of Thailand views, modern rooms, and direct beach access. Perfect for a relaxing coastal getaway.',
                'address'          => 'Ochheuteal Beach, Sihanoukville',
                'price_per_night'  => 95,
                'star_rating'      => 4,
                'website_url'      => null,
                'facebook_url'     => 'https://www.facebook.com/ReeHotelSihanoukville',
                'google_maps_url'  => 'https://maps.google.com/?q=Ree+Hotel+Sihanoukville',
            ],
            [
                'name'             => 'Bohemiaz Resort & Spa',
                'province_id'      => 4, // Kampot
                'user_id'          => $admin->id,
                'description'      => 'A riverside eco-resort in Kampot surrounded by pepper plantations and mountain views. Enjoy yoga retreats, farm-to-table dining, and a peaceful atmosphere.',
                'address'          => 'Teuk Chhou District, Kampot',
                'price_per_night'  => 65,
                'star_rating'      => 3,
                'website_url'      => null,
                'facebook_url'     => 'https://www.facebook.com/BohemiazResort',
                'google_maps_url'  => 'https://maps.google.com/?q=Bohemiaz+Resort+Kampot',
            ],
            [
                'name'             => 'La Villa Battambang',
                'province_id'      => 5, // Battambang
                'user_id'          => $admin->id,
                'description'      => 'A charming French colonial villa turned boutique hotel sitting on the banks of the Sangker River. Enjoy authentic Khmer architecture and warm local hospitality.',
                'address'          => 'Street 1.5, Battambang',
                'price_per_night'  => 55,
                'star_rating'      => 3,
                'website_url'      => null,
                'facebook_url'     => 'https://www.facebook.com/LaVillaBattambang',
                'google_maps_url'  => 'https://maps.google.com/?q=La+Villa+Battambang',
            ],
            [
                'name'             => 'Veranda Natural Resort',
                'province_id'      => 6, // Kep
                'user_id'          => $admin->id,
                'description'      => 'Perched on a hillside overlooking the Gulf of Thailand in Kep, this resort offers stunning sea views, wooden bungalows nestled in lush jungle, and fresh seafood dining.',
                'address'          => 'Kep National Park, Kep',
                'price_per_night'  => 80,
                'star_rating'      => 4,
                'website_url'      => 'https://www.veranda-resort.com',
                'facebook_url'     => null,
                'google_maps_url'  => 'https://maps.google.com/?q=Veranda+Natural+Resort+Kep',
            ],
        ];

        foreach ($hotels as $hotelData) {
            Hotel::create($hotelData);
        }

        // ── 5. Attach amenities to hotels ─────────────────────────────────────
        // Raffles — all amenities
        Hotel::find(1)->amenities()->attach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        // Sokha Angkor — most amenities
        Hotel::find(2)->amenities()->attach([1, 2, 3, 4, 5, 6, 7, 8]);
        // Ree Hotel — basic amenities
        Hotel::find(3)->amenities()->attach([1, 3, 4, 5, 10]);
        // Bohemiaz — eco amenities
        Hotel::find(4)->amenities()->attach([1, 2, 4, 5, 9]);
        // La Villa — basic
        Hotel::find(5)->amenities()->attach([1, 3, 4]);
        // Veranda — resort amenities
        Hotel::find(6)->amenities()->attach([1, 2, 4, 5, 9, 10]);
    }
}
