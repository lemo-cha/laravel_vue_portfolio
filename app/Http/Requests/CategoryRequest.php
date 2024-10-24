<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'custom_id' => ['required','unique:categories,custom_id','integer','between:1,999'],
                'name' => ['required','unique:categories,name','string','max:50'],
            ];
        }else if($this->isMethod('patch')){
            return [
                'custom_id' => ['required','unique:categories,custom_id,' .$this->route('category'),'integer','between:1,999'],
                'name' => ['required','unique:categories,name,' .$this->route('category'),'string','max:50'],
            ];
        };
    }

    public function attributes(): array
    {
        return [
            'name' => 'カテゴリー名',
        ];
    }
}