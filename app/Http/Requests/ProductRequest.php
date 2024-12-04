<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return [
                'custom_id' => ['required',Rule::unique('products','custom_id')],
                'category_id' => ['required',Rule::exists('categories','id')],
                'maker_id' => ['required',Rule::exists('makers','id')],
                'unit_id' => ['required',Rule::exists('units','id')],
                'name' => ['required','string','max:30'],
                'size' => ['nullable',],
                'product_number' => ['nullable',],
                'description' => ['nullable',],
                'image_1' => ['required','image','mimes:jpeg,png,gif','max:5120','dimensions:min_width=100,min_height=100',],
                'image_2' => ['nullable','image','mimes:jpeg,png,gif','max:5120','dimensions:min_width=100,min_height=100',],
                'image_3' => ['nullable','image','mimes:jpeg,png,gif','max:5120','dimensions:min_width=100,min_height=100',],
                'remarks' => ['nullable','max:255'],
                'status' => ['required',Rule::in(ProductStatus::cases()),]
            ];
        }elseif($this->isMethod('patch')){
            // dd(request());

            //現在dbに登録されているデータ
            $product = $this->route('product');

            //画像update用ルール
            $imageRules = function ($column, $isRequired = false) use ($product) {
                // バリデーションの初期値（nullable または required）
                $rules = [$isRequired ? 'required' : 'nullable'];
            
                // 値が送信されている場合のみ追加のバリデーションを適用
                if ($this->filled($column)) {
                    // 画像ファイルの場合
                    if ($this->hasFile($column)) {
                        $rules = array_merge($rules, [
                            'image', 'mimes:jpeg,png,gif', 'max:5120', 'dimensions:min_width=100,min_height=100',
                        ]);
                    } else {
                        // 値がDBの値と同じ場合は `string` を許容
                        if ($this->input($column) === $product->$column) {
                            $rules = array_merge($rules, ['string']);
                        } else {
                            // 値が異なる場合は画像である必要がある
                            $rules = array_merge($rules, ['image']);
                        }
                    }
                }
            
                return $rules;
            };
            
            return [
                'custom_id' => ['required',Rule::unique('products', 'custom_id')->ignore($this->route('product')->id)],
                'category_id' => ['required',Rule::exists('categories','id')],
                'maker_id' => ['required',Rule::exists('makers','id')],
                'unit_id' => ['required',Rule::exists('units','id')],
                'name' => ['required','string','max:30'],
                'size' => ['nullable',],
                'product_number' => ['nullable',],
                'description' => ['nullable',],
                'image_1' => $imageRules('image_1',true),
                'image_2' => $imageRules('image_2'),
                'image_3' => $imageRules('image_3'),
                'remarks' => ['nullable','max:255'],
                'status' => ['required',Rule::in(ProductStatus::cases()),]
            ];
        };
    }
    public function attributes(): array
    {
        return [
            'name' => '商品名',
        ];
    }
}