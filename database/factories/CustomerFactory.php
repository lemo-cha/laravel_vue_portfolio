<?php

namespace Database\Factories;

use App\Enums\CompanyType;
use App\Helpers\FormatHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->lastKanaName().fake()->firstKanaName();
        return [
            'custom_id' => fake()->unique()->randomNumber(3,true),
            'company_type' => fake()->randomElement(array_map(fn($case) => $case->value, CompanyType::cases())),
            'name' => $name,
            'kana' => mb_convert_kana($name,"KVc"),
            'tel' => str_replace('-','',fake()->phoneNumber()),
            'zip' => fake()->postcode(),
            'address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'billing_zip' => fake()->postcode(),
            'billing_address' => fake()->prefecture().fake()->city().fake()->streetAddress(),
            'closing_date' => fake()->randomElement(FormatHelper::getClosingDate()),
            'bank_name' => fake()->lastName().'銀行',
            'bank_number' => fake()->randomNumber([8,true]),
            'remarks' => fake()->realText(30),
            'is_active' => fake()->randomElement(array_map(fn($case) => $case['value'], FormatHelper::getActiveLabelList())),
        ];
    }
}
