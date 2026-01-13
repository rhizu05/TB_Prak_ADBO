<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin Resto',
            'email' => 'admin@restoqr.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Koki Dapur',
            'email' => 'koki@restoqr.com',
            'password' => bcrypt('password'),
            'role' => 'koki',
        ]);

        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@restoqr.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);
    }
}
