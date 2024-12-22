<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Define the relationships between products and services
        $productServiceRelations = [
            // Regular Laundry
            ['product_id' => 1, 'service_id' => 1], 
            ['product_id' => 2, 'service_id' => 1], 
            ['product_id' => 3, 'service_id' => 1], 

            // Dry Cleaning
            ['product_id' => 4, 'service_id' => 2], 
            ['product_id' => 5, 'service_id' => 2], 
            ['product_id' => 6, 'service_id' => 2], 

            // Express Laundry
            ['product_id' => 7, 'service_id' => 3], 
            ['product_id' => 8, 'service_id' => 3], 
            ['product_id' => 9, 'service_id' => 3], 

            // Heavy Duty Laundry
            ['product_id' => 10, 'service_id' => 4], 
            ['product_id' => 11, 'service_id' => 4], 
            ['product_id' => 12, 'service_id' => 4], 
        ];

        // Insert the relationships into the product_service table
        DB::table('product_service')->insert($productServiceRelations);
    }
}
