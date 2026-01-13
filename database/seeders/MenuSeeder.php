<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories
        $catFoodId = DB::table('categories')->insertGetId([
            'name' => 'Makanan Berat',
            'type' => 'makanan',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $catDrinkId = DB::table('categories')->insertGetId([
            'name' => 'Minuman Segar',
            'type' => 'minuman',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $catSnackId = DB::table('categories')->insertGetId([
            'name' => 'Cemilan',
            'type' => 'snack',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // 2. Create Products
        $products = [
            [
                'category_id' => $catFoodId,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur mata sapi, ayam suwir, dan kerupuk.',
                'price' => 25000,
                'is_available' => true,
                'image' => null, // No image for now
            ],
            [
                'category_id' => $catFoodId,
                'name' => 'Ayam Bakar Madu',
                'description' => 'Ayam bakar dengan olesan madu murni, disajikan dengan lalapan.',
                'price' => 30000,
                'is_available' => true,
                'image' => null,
            ],
            [
                'category_id' => $catDrinkId,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin segar.',
                'price' => 5000,
                'is_available' => true,
                'image' => null,
            ],
            [
                'category_id' => $catDrinkId,
                'name' => 'Jus Alpukat',
                'description' => 'Jus alpukat kental dengan susu coklat.',
                'price' => 15000,
                'is_available' => true,
                'image' => null,
            ],
            [
                'category_id' => $catSnackId,
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng renyah dengan saus sambal.',
                'price' => 12000,
                'is_available' => true,
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert(array_merge($product, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
