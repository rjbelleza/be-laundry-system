<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', 
            'address' => '1091 zone 2 kauswagan cagayan de oro city',
            'mobile' => 914678762,
            'postal_code' => $faker->numberBetween(1000, 9999), // Generate 4-digit postal code
        ]);

        User::create([ 
            'name' => 'Customer User', 
            'email' => 'customer@example.com', 
            'password' => Hash::make('password'), 
            'role' => 'customer', 
            'address' => 'Customer Address', 
            'mobile' => '987654321', 
            'postal_code' => '4321', 
        ]);

        User::factory()->count(20)->create([
            'address' => '27 North A San Miguel Street Camaman-an',
            'mobile' => 926863278,
            'postal_code' => $faker->numberBetween(1000, 9999), // Generate 4-digit postal code
        ]);
    }
}
