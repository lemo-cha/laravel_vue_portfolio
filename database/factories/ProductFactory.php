<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Maker;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private function fakeJpData($minStr,$maxStr) //日本語で10文字以下も入れたいため
    {
        $length = random_int($minStr,$maxStr);
        if($length < 10){
            return mb_substr(fake()->realText(10),0,$length);
        }else{
            return fake()->realText($length);
        }
    }

    public function definition(): array
    {
        $dummyImages = [
            'images/middle-photo0000-0161.jpg','images/middle-photo0000-0272.jpg','images/middle-photo0000-0418.jpg',
            'images/middle-photo0000-2064.jpg','images/middle-photo0000-2065.jpg','images/middle-photo0000-2110.jpg',
            'images/middle-photo0000-2113.jpg','images/middle-photo0000-2114.jpg','images/middle-photo0000-2170.jpg',
            'images/middle-photo0000-4087.jpg','images/middle-photo0000-4234.jpg','images/middle-photo0000-4414.jpg',
            'images/middle-photo0000-4453.jpg','images/middle-photo0000-5560.jpg','images/middle-photo0000-5999.jpg',
            'images/middle-photo0000-6026.jpg','images/middle-photo0000-6033.jpg','images/middle-photo0000-6135.jpg',
            'images/middle-photo0000-6141.jpg','images/middle-photo0000-6147.jpg','images/middle-photo0000-6321.jpg',
            'images/middle-photo0000-6340.jpg','images/middle-photo0000-6342.jpg','images/middle-photo0000-6364.jpg',
            'images/middle-photo0000-6517.jpg','images/middle-photo0000-6914.jpg','images/middle-photo0000-7995.jpg',
            'images/middle-photo0000-8004.jpg',
        ];

        //画像1枚目は必須、2,3枚目は任意のためランダムにする
        $image_1 = Arr::random($dummyImages);
        $image_2 = fake()->optional(0.7)->passthrough(Arr::random($dummyImages));
        $image_3 = $image_2 === null ? null : fake()->optional(0.5)->passthrough(Arr::random($dummyImages));

        return [
            'custom_id' => fake()->unique()->randomNumber(3,true),
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'maker_id' => Maker::query()->inRandomOrder()->value('id'),
            'unit_id' => Unit::query()->inRandomOrder()->value('id'),
            'name' => $this->fakeJpData(3,15),
            'size' => fake()->randomElement(["小","中","大","10本","10×30","3/8×30","100g","色々なサイズ"]), // *** size_typeとsize_valueなどに分けて、入力値を統一する
            'product_number' => "メーカーの品番".fake()->unique()->randomNumber(3,true),
            'description' => "説明文を書く".$this->fakeJpData(5,70),
            'image_1' => $image_1,
            'image_2' => $image_2,
            'image_3' => $image_3,
            'remarks' => fake()->randomElement([null,"備考を書きます","備考を書きます".fake()->realText(random_int(10,50))]),
            'status' => fake()->randomElement([0,1,1,1,1,1,1,1,1,6,6]), //Enumで色々定義してあるが、販売停止(0)、販売中(1)、在庫切れ(6)のみダミーデータに入れる。
        ];
    }
}