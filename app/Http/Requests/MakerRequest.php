<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakerRequest extends FormRequest
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
                'custom_id' => ['required','unique:makers,custom_id'],
                'company_type' => ['required','integer'],
                'name' => ['required','string','max:30',
                            Rule::unique('makers')->where(function($query){
                                return $query->where('brand',$this->input('brand'));
                            })],
                'brand' => ['nullable','string','max:30'],
            ];
        }else if($this->isMethod('patch')){
            // dd($this->route('maker')->id);
            return [
                // 'custom_id' => ['required','unique:makers,custom_id,' .$this->route('maker')->id,],
                'custom_id' => ['required',Rule::unique('makers','custom_id')->ignore($this->route('maker')->id),],

                'company_type' => ['required','integer'],
                'name' => ['required','string','max:30',
                            Rule::unique('makers')->where(function($query){
                                return $query->where('brand',$this->input('brand'));
                            })->ignore($this->route('maker')->id)],
                'brand' => ['nullable','string','max:30'],
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'name' => 'メーカー名',
            'brand' => 'ブランド名',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'この内容は登録済みです',
        ];
    }
}