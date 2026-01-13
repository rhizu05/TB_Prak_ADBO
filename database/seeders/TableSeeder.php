<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if table 1 exists, if not create it
        if (!DB::table('tables')->where('number', 1)->exists()) {
            DB::table('tables')->insert([
                'number' => 1,
                'qr_url' => url('/order/1'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
         if (!DB::table('tables')->where('number', 2)->exists()) {
            DB::table('tables')->insert([
                'number' => 2,
                'qr_url' => url('/order/2'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
