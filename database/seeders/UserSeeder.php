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

        // Create an admin user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', 
            'address' => '1091 zone 2 kauswagan cagayan de oro city',
            'mobile' => '914678762', // Ensure mobile is a string
            'postal_code' => $faker->numberBetween(1000, 9999), // Generate 4-digit postal code
        ]);

        // Create a customer user
        User::create([ 
            'name' => 'Customer User', 
            'email' => 'customer@example.com', 
            'password' => Hash::make('password'), 
            'role' => 'customer', 
            'address' => 'Customer Address', 
            'mobile' => '987654321', 
            'postal_code' => '4321', 
        ]);

        // Create a sample courier user
        User::create([
            'name' => 'Bobby Douglas',
            'email' => 'mheathcote@example.com',
            'role' => 'courier',
            'password' => Hash::make('password'),
            'address' => '789 Courier Blvd', // Ensure this field is populated
            'mobile' => '1234567890',
            'postal_code' => '5432',
        ]);

        // Create 20 random users using the factory
        User::factory()->count(20)->create()->each(function ($user) use ($faker) {
            $user->update([
                'address' => $faker->address, // Ensure address is populated
                'mobile' => $faker->phoneNumber, // Generate a random phone number
                'postal_code' => $faker->numberBetween(1000, 9999), // Generate 4-digit postal code
            ]);
        });
    }
}
