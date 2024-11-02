<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'custom_id' => "1",
            'company_type' => 3,
            'name' => "あいう",
            'kana' => "あいう",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'billing_zip' => fake()->postcode(),
            'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            'remarks' => fake()->realText(30),
            'is_active' => 1,
        ]);
        Supplier::create([
            //nullable確認のため
            'custom_id' => "2",
            'company_type' => 5,
            'name' => "かきく",
            'kana' => "かきく",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            // 'billing_zip' => fake()->postcode(),
            // 'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            // 'remarks' => fake()->realText(30),
            'is_active' => 1,
        ]);
        Supplier::create([
            'custom_id' => "3",
            'company_type' => 15,
            'name' => "さしす",
            'kana' => "さしす",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'billing_zip' => fake()->postcode(),
            'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            'remarks' => fake()->realText(30),
            'is_active' => 0,
        ]);

        Supplier::factory(30)->create();
    }
}
