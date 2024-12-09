<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'custom_id' => 1,
            'name' => '個',
        ]);
        Unit::create([
            'custom_id' => 2,
            'name' => '本',
        ]);
        Unit::create([
            'custom_id' => 3,
            'name' => 'パック',
        ]);
    }
}
