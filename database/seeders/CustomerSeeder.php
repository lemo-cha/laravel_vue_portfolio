<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'custom_id' => "1",
            'company_type' => 3,
            'name' => "アイウ",
            'kana' => "あいう",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'billing_zip' => fake()->postcode(),
            'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'closing_date' => fake()->randomElement([10,15,19,20,25,31]),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            'remarks' => fake()->realText(30),
            'is_active' => 1,
        ]);
        Customer::create([
            //nullable確認のため
            'custom_id' => "2",
            'company_type' => 5,
            'name' => "カキク",
            'kana' => "かきく",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            // 'billing_zip' => fake()->postcode(),
            // 'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'closing_date' => fake()->randomElement([10,15,19,20,25,31]),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            // 'remarks' => fake()->realText(30),
            'is_active' => 1,
        ]);
        Customer::create([
            'custom_id' => "3",
            'company_type' => 15,
            'name' => "サシス",
            'kana' => "さしす",
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'billing_zip' => fake()->postcode(),
            'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'closing_date' => fake()->randomElement([10,15,19,20,25,31]),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            'remarks' => fake()->realText(30),
            'is_active' => 0,
        ]);

        Customer::factory(30)->create();
    }
}
