<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createAdminPermission = Permission::create(['name' => 'create Admin']);

        $superAdminRole = Role::findByName('Super Admin');

        $superAdminRole->givePermissionTo($createAdminPermission);
    }
}
