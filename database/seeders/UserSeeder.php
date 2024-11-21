<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'address' => '123 Main St, Anytown, USA', // Example address
            'mobile' => 12345678901, // Example mobile number (11 digits)
            'postal_code' => 123456, // Example postal code (5-6 digits)
        ]);

        User::factory()->count(20)->create([
            'address' => '123 Factory Rd, Factory Town, USA', // Default address for factory users
            'mobile' => 98765432101, // Default mobile number for factory users
            'postal_code' => 654321, // Default postal code for factory users
        ]);
    }
}
