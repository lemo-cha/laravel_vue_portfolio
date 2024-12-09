<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Maker;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // private function fakeJpData($minStr,$maxStr)
        // {
        //     $length = random_int($minStr,$maxStr);
        //     if($length < 10){
        //         return mb_substr(fake()->realText(10),0,$length);
        //     }else{
        //         return fake()->realText($length);
        //     }
        // }
    
        // public function definition(): array
        // {
        //     $image_1 = fake()->imageUrl();
        //     $image_2 = fake()->randomElement([null,fake()->imageUrl(),fake()->imageUrl(),fake()->imageUrl()]);
        //     $image_3 = $image_2 === null ? null : fake()->randomElement([null,fake()->imageUrl(),fake()->imageUrl()]);
    
        //     return [
        //         'custom_id' => fake()->unique()->randomNumber(3,true),
        //         'category_id' => Category::query()->inRandomOrder()->value('id'),
        //         'maker_id' => Maker::query()->inRandomOrder()->value('id'),
        //         'unit_id' => Unit::query()->inRandomOrder()->value('id'),
        //         'name' => $this->fakeJpData(3,15),
        //         'size' => fake()->randomElement(["小","中","大","10本","10×30","3/8×30","100g","色々なサイズ"]), // *** size_typeとsize_valueなどに分けて、入力値を統一する
        //         'product_number' => "メーカーの品番".fake()->unique()->randomNumber(3,true),
        //         'description' => "説明文を書く".$this->fakeJpData(5,70),
        //         'image_1' => $image_1,
        //         'image_2' => $image_2,
        //         'image_3' => $image_3,
        //         'remarks' => fake()->randomElement([null,"備考を書きます","備考を書きます".fake()->realText(random_int(10,50))]),
        //     ];
        // }

        Product::factory(150)->create();
    }
}