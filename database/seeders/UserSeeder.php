<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $hashedPassword = Hash::make('password');


        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => $hashedPassword,
        ])->assignRole(Role::findByName('User'));

        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'testuser2@example.com',
            'password' => $hashedPassword,
        ])->assignRole(Role::findByName('User'));

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => $hashedPassword,
        ])->assignRole(Role::findByName('Admin'));

        User::factory()->create([
            'name' => 'Test Super Admin',
            'email' => 'testsuperadmin@example.com',
            'password' => $hashedPassword,
        ])->assignRole(Role::findByName('Super Admin'));
    }
}
