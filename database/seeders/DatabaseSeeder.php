<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default Demo Users
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            ['email' => 'admin@travelmarket.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '01700000001',
                'is_active' => true,
            ]
        );

        $agency = User::updateOrCreate(
            ['email' => 'agency@travelmarket.com'],
            [
                'name' => 'Green Travel Agency',
                'password' => Hash::make('password'),
                'role' => 'agency_owner',
                'phone' => '01700000002',
                'is_active' => true,
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@travelmarket.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '01700000003',
                'is_active' => true,
            ]
        );

        $guide = User::updateOrCreate(
            ['email' => 'guide@travelmarket.com'],
            [
                'name' => 'Demo Tour Guide',
                'password' => Hash::make('password'),
                'role' => 'tour_guide',
                'phone' => '01700000004',
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Demo Tour Packages
        |--------------------------------------------------------------------------
        */

        TourPackage::updateOrCreate(
            ['title' => "Cox's Bazar Beach Tour"],
            [
                'agency_id' => $agency->id,
                'destination' => "Cox's Bazar",
                'description' => 'A relaxing beach tour including hotel stay, sightseeing, and local seafood experience.',
                'price' => 12000,
                'duration' => 3,
                'max_capacity' => 20,
                'available_seats' => 20,
                'status' => 'available',
                'tags' => 'beach, family, relaxing',
            ]
        );

        TourPackage::updateOrCreate(
            ['title' => 'Saint Martin Island Tour'],
            [
                'agency_id' => $agency->id,
                'destination' => 'Saint Martin',
                'description' => 'Enjoy island views, coral beach, boat travel, and peaceful night stay.',
                'price' => 14000,
                'duration' => 3,
                'max_capacity' => 15,
                'available_seats' => 15,
                'status' => 'available',
                'tags' => 'beach, island, relaxing',
            ]
        );

        TourPackage::updateOrCreate(
            ['title' => 'Sylhet Tea Garden Tour'],
            [
                'agency_id' => $agency->id,
                'destination' => 'Sylhet',
                'description' => 'Explore tea gardens, green hills, waterfalls, and local cultural spots.',
                'price' => 10000,
                'duration' => 2,
                'max_capacity' => 25,
                'available_seats' => 25,
                'status' => 'available',
                'tags' => 'nature, family, relaxing',
            ]
        );

        TourPackage::updateOrCreate(
            ['title' => 'Bandarban Adventure Trip'],
            [
                'agency_id' => $agency->id,
                'destination' => 'Bandarban',
                'description' => 'Adventure tour with hill tracking, scenic viewpoints, and local tribal culture.',
                'price' => 16000,
                'duration' => 4,
                'max_capacity' => 18,
                'available_seats' => 18,
                'status' => 'available',
                'tags' => 'adventure, hills, nature',
            ]
        );
    }
}