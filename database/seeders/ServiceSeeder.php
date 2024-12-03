<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the services you want to seed
        $services = [
            ['name' => 'Regular Laundry', 'description' => 'Basic laundry service', 'price' => 5.00],
            ['name' => 'Dry Cleaning', 'description' => 'Dry cleaning service', 'price' => 10.00],
            ['name' => 'Express Laundry', 'description' => 'Same day laundry service', 'price' => 7.50],
            ['name' => 'Heavy Duty Laundry', 'description' => 'Laundry service for heavy items', 'price' => 12.00],
        ];

        // Insert the services into the database
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
