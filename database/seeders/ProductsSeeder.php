<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        
        $products = [
            // Regular Laundry
            [
                'name' => 'Regular Laundry - Liquid Detergent',
                'description' => 'Tide Original Liquid Laundry Detergent for everyday clothes.',
                'price' => 10.00,
            ],
            [
                'name' => 'Regular Laundry - Powder Detergent',
                'description' => 'Gain Original Powder Laundry Detergent for everyday clothes.',
                'price' => 8.00,
            ],
            [
                'name' => 'Regular Laundry - Fabric Softener',
                'description' => 'Downy Unstoppables Fabric Softener for a fresh scent.',
                'price' => 5.00,
            ],

            // Dry Cleaning
            [
                'name' => 'Dry Cleaning - Perchloroethylene Solvent',
                'description' => 'Professional dry cleaning solvent for delicate fabrics.',
                'price' => 15.00,
            ],
            [
                'name' => 'Dry Cleaning - Spot Cleaner',
                'description' => 'Shout Advanced Stain Remover for pre-treating stains.',
                'price' => 7.00,
            ],
            [
                'name' => 'Dry Cleaning - Fabric Finisher',
                'description' => 'Scotchgard Fabric & Upholstery Protector for added protection.',
                'price' => 12.00,
            ],

            // Express Laundry
            [
                'name' => 'Express Laundry - High-Efficiency Detergent',
                'description' => 'Tide HE Turbo Clean Laundry Detergent for quick washes.',
                'price' => 11.00,
            ],
            [
                'name' => 'Express Laundry - Fast-Acting Stain Remover',
                'description' => 'OxiClean Versatile Stain Remover for urgent needs.',
                'price' => 9.00,
            ],
            [
                'name' => 'Express Laundry - Fabric Refresher',
                'description' => 'Febreze Fabric Refresher for eliminating odors.',
                'price' => 6.00,
            ],

            // Heavy Duty Laundry
            [
                'name' => 'Heavy Duty Laundry - Heavy-Duty Detergent',
                'description' => 'Tide Heavy Duty Laundry Detergent for tough stains.',
                'price' => 14.00,
            ],
            [
                'name' => 'Heavy Duty Laundry - Pre-Treatment Spray',
                'description' => 'Shout Advanced Stain Remover for heavy-duty stains.',
                'price' => 8.00,
            ],
            [
                'name' => 'Heavy Duty Laundry - Fabric Softener',
                'description' => 'Downy Unstoppables Fabric Softener for heavy-duty use.',
                'price' => 5.00,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
