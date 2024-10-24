<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'custom_id' => 1,
            'name' => '鋲螺',
        ]);
        Category::create([
            'custom_id' => 2,
            'name' => '工具',
        ]);
        Category::create([
            'custom_id' => 3,
            'name' => '電動工具',
        ]);
    }
}