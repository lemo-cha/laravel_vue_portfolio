<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,
            MakerSeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}