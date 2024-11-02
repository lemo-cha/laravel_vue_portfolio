<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
                'custom_id' => ['required','unique:suppliers,custom_id'],
                'company_type' => ['required','digits_between:1,2'],
                'name' => ['required','string','max:30',
                            Rule::unique('suppliers')->where(function($query){
                                return $query->where('company_type',$this->input('company_type'));
                            })],
                'kana' => ['required','regex:/^[\p{Hiragana}]+$/u','max:30'],
                'tel' => ['required', 'string', 'regex:/\A0\d{9,10}\z/'],
                'zip' => ['required','digits:7'],
                'address' => ['required','string','max:50'],
                'billing_zip' => ['nullable','digits:7'],
                'billing_address' => ['nullable','string','max:50'],
                'bank_name' => ['required','string','max:20'],
                'bank_number' => ['required','string','digits_between:7,10'],
                'remarks' => ['nullable','max:50'],
                'is_active' => ['required','boolean'],
            ];
        }else if($this->isMethod('patch')){
            return [
                'custom_id' => ['required',Rule::unique('suppliers','custom_id')->ignore($this->route('supplier')->id),],
                'company_type' => ['required','digits_between:1,2'],
                'name' => ['required','string','max:30',
                            Rule::unique('suppliers')->where(function($query){
                                return $query->where('company_type',$this->input('company_type'));
                            })->ignore($this->route('supplier')->id),],
                'kana' => ['required','regex:/^[\p{Hiragana}]+$/u','max:30'],
                'tel' => ['required', 'string', 'regex:/\A0\d{9,10}\z/'],
                'zip' => ['required','digits:7'],
                'address' => ['required','string','max:50'],
                'billing_zip' => ['nullable','digits:7'],
                'billing_address' => ['nullable','string','max:50'],
                'bank_name' => ['required','string','max:20'],
                'bank_number' => ['required','digits_between:7,10'],
                'remarks' => ['nullable','max:50'],
                'is_active' => ['required','boolean'],
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'name' => '会社名',
        ];
    }
}


// 'kana' => 'regex:/^[ぁ-ゖゝゞ]+$/'
// 'regex:/^[ぁ-んゔゕゖゝゞー]+$/u'
// 'regex:/^[\p{Hiragana}]+$/u'