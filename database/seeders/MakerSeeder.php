<?php

namespace Database\Seeders;

use App\Models\Maker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Maker::create([
            'custom_id' => "na001000",
            'company_type' => 17,
            'name' => 'なにぬねの',
        ]);
        Maker::create([
            'custom_id' => "sa001001",
            'company_type' => 11,
            'name' => 'さしすせそ',
            'brand' => 'サシスセソ',
        ]);
        Maker::create([
            'custom_id' => "a001000",
            'company_type' => 1,
            'name' => 'あいうえお',
            'brand' => 'アイウエオ',
        ]);
        Maker::create([
            'custom_id' => "a001001",
            'company_type' => 1,
            'name' => 'あいうえお',
            'brand' => 'aiueo',
        ]);
        Maker::create([
            'custom_id' => "ru001002",
            'company_type' => 0,
            'name' => 'るるる',
            'brand' => 'るるるん'
        ]);
        Maker::create([
            'custom_id' => "ru002000",
            'company_type' => 0,
            'name' => 'るらら',
        ]);
        Maker::create([
            'custom_id' => "ru002001",
            'company_type' => 0,
            'name' => 'るらら',
            'brand' => 'るららん',
        ]);
        Maker::create([
            'custom_id' => "ru001001",
            'company_type' => 0,
            'name' => 'るるる',
        ]);
        Maker::create([
            'custom_id' => "ka001000",
            'company_type' => 6,
            'name' => 'かきくけこ',
        ]);
        Maker::create([
            'custom_id' => "ta001000",
            'company_type' => 16,
            'name' => 'たちつてと',
        ]);
        Maker::create([
            'custom_id' => "ha001000",
            'company_type' => 0,
            'name' => 'はひふへほ',
        ]);


        // Maker::create([
        //     'custom_id' => "a001000",
        //     'company_type' => 1,
        //     'name' => 'あいうえお',
        //     'brand' => 'アイウエオ',
        // ]);
        // Maker::create([
        //     'custom_id' => "a001001",
        //     'company_type' => 1,
        //     'name' => 'あいうえお',
        //     'brand' => 'aiueo',
        // ]);
        // Maker::create([
        //     'custom_id' => "ka001000",
        //     'company_type' => 6,
        //     'name' => 'かきくけこ',
        // ]);
        // Maker::create([
        //     'custom_id' => "sa001001",
        //     'company_type' => 11,
        //     'name' => 'さしすせそ',
        //     'brand' => 'サシスセソ',
        // ]);
        // Maker::create([
        //     'custom_id' => "ta001",
        //     'company_type' => 16,
        //     'name' => 'たちつてと',
        // ]);
        // Maker::create([
        //     'custom_id' => "na001",
        //     'company_type' => 17,
        //     'name' => 'なにぬねの',
        // ]);
        // Maker::create([
        //     'custom_id' => "ha001",
        //     'company_type' => 0,
        //     'name' => 'はひふへほ',
        // ]);
        // Maker::create([
        //     'custom_id' => "ru001",
        //     'company_type' => 0,
        //     'name' => 'るるる',
        // ]);
    }
}
