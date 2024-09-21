<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
        ]);


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(Role::findByName('User'));

        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'testuser2@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(Role::findByName('User'));

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(Role::findByName('Admin'));

        User::factory()->create([
            'name' => 'Test Super Admin',
            'email' => 'testsuperadmin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole(Role::findByName('Super Admin'));
    }
}