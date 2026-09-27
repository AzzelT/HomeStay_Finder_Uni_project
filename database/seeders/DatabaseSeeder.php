<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Province;
use App\Models\Amenity;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin User ─────────────────────────────────────────────────────
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@homestayfinder.test'],
            [
                'name' => 'Homestay Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // ── 2. Provinces ─────────────────────────────────────────────────────
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
            Province::firstOrCreate(['name' => $name]);
        }

        // ── 3. Amenities ─────────────────────────────────────────────────────
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
            Amenity::firstOrCreate(['name' => $name]);
        }

        // ── 4. Hotels ─────────────────────────────────────────────────────────
        $hotels = [
            [
                'name' => 'Raffles Hotel Le Royal',
                'province_id' => 1,
                'user_id' => $admin->id,
                'description' => 'A legendary heritage hotel in the heart of Phnom Penh, combining colonial elegance with modern luxury. Experience world-class service and timeless Cambodian hospitality.',
                'address' => '92 Rukhak Vithei Daun Penh, Phnom Penh',
                'price_per_night' => 250,
                'star_rating' => 5,
                'website_url' => 'https://www.raffles.com/phnom-penh',
                'facebook_url' => 'https://www.facebook.com/RafflesHotelLeRoyal',
                'google_maps_url' => 'https://maps.google.com/?q=Raffles+Hotel+Le+Royal+Phnom+Penh',
            ],
            [
                'name' => 'Sokha Angkor Resort',
                'province_id' => 2,
                'user_id' => $admin->id,
                'description' => 'Set amidst lush tropical gardens near the legendary Angkor temples, Sokha Angkor Resort offers a tranquil escape with stunning views and exceptional amenities.',
                'address' => 'National Road No. 6, Siem Reap',
                'price_per_night' => 180,
                'star_rating' => 5,
                'website_url' => 'https://www.sokhahotels.com/angkor',
                'facebook_url' => null,
                'google_maps_url' => 'https://maps.google.com/?q=Sokha+Angkor+Resort+Siem+Reap',
            ],
            [
                'name' => 'Ree Hotel Sihanoukville',
                'province_id' => 3,
                'user_id' => $admin->id,
                'description' => 'A beachfront boutique hotel offering stunning Gulf of Thailand views, modern rooms, and direct beach access. Perfect for a relaxing coastal getaway.',
                'address' => 'Ochheuteal Beach, Sihanoukville',
                'price_per_night' => 95,
                'star_rating' => 4,
                'website_url' => null,
                'facebook_url' => 'https://www.facebook.com/ReeHotelSihanoukville',
                'google_maps_url' => 'https://maps.google.com/?q=Ree+Hotel+Sihanoukville',
            ],
            [
                'name' => 'Bohemiaz Resort & Spa',
                'province_id' => 4,
                'user_id' => $admin->id,
                'description' => 'A riverside eco-resort in Kampot surrounded by pepper plantations and mountain views. Enjoy yoga retreats, farm-to-table dining, and a peaceful atmosphere.',
                'address' => 'Teuk Chhou District, Kampot',
                'price_per_night' => 65,
                'star_rating' => 3,
                'website_url' => null,
                'facebook_url' => 'https://www.facebook.com/BohemiazResort',
                'google_maps_url' => 'https://maps.google.com/?q=Bohemiaz+Resort+Kampot',
            ],
            [
                'name' => 'La Villa Battambang',
                'province_id' => 5,
                'user_id' => $admin->id,
                'description' => 'A charming French colonial villa turned boutique hotel sitting on the banks of the Sangker River. Enjoy authentic Khmer architecture and warm local hospitality.',
                'address' => 'Street 1.5, Battambang',
                'price_per_night' => 55,
                'star_rating' => 3,
                'website_url' => null,
                'facebook_url' => 'https://www.facebook.com/LaVillaBattambang',
                'google_maps_url' => 'https://maps.google.com/?q=La+Villa+Battambang',
            ],
            [
                'name' => 'Veranda Natural Resort',
                'province_id' => 6,
                'user_id' => $admin->id,
                'description' => 'Perched on a hillside overlooking the Gulf of Thailand in Kep, this resort offers stunning sea views, wooden bungalows nestled in lush jungle, and fresh seafood dining.',
                'address' => 'Kep National Park, Kep',
                'price_per_night' => 80,
                'star_rating' => 4,
                'website_url' => 'https://www.veranda-resort.com',
                'facebook_url' => null,
                'google_maps_url' => 'https://maps.google.com/?q=Veranda+Natural+Resort+Kep',
            ],
        ];

        foreach ($hotels as $hotelData) {
            $hotel = Hotel::firstOrCreate(
                [
                    'name' => $hotelData['name'],
                    'province_id' => $hotelData['province_id'],
                ],
                $hotelData
            );

            // Attach amenities without creating duplicate pivot records.
            $amenitySets = [
                'Raffles Hotel Le Royal' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                'Sokha Angkor Resort' => [1, 2, 3, 4, 5, 6, 7, 8],
                'Ree Hotel Sihanoukville' => [1, 3, 4, 5, 10],
                'Bohemiaz Resort & Spa' => [1, 2, 4, 5, 9],
                'La Villa Battambang' => [1, 3, 4],
                'Veranda Natural Resort' => [1, 2, 4, 5, 9, 10],
            ];

            if (isset($amenitySets[$hotel->name])) {
                $hotel->amenities()->syncWithoutDetaching($amenitySets[$hotel->name]);
            }
        }
    }
}