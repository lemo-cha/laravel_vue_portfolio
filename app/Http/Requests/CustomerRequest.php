<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
                'custom_id' => ['required','unique:customers,custom_id'],
                'company_type' => ['required','digits_between:1,2'],
                'name' => ['required','string','max:30',
                            Rule::unique('customers')->where(function($query){
                                return $query->where('company_type',$this->input('company_type'));
                            })],
                'kana' => ['required','regex:/^[ぁ-ん]+$/','max:30'],
                'tel' => ['required', 'string', 'regex:/\A0\d{9,10}\z/'],
                'zip' => ['required','digits:7'],
                'address' => ['required','string','max:50'],
                'claim_zip' => ['nullable','digits:7'],
                'claim_address' => ['nullable','string','max:50'],
                'invoice_date' => ['required','integer'],
                'bank_name' => ['required','string','max:20'],
                'bank_number' => ['required','string','digits_between:7,10'],
                'remarks' => ['nullable','max:50'],
                'is_active' => ['required','boolean'],
            ];
        }else if($this->isMethod('patch')){
            return [
                'custom_id' => ['required',Rule::unique('customers','custom_id')->ignore($this->route('customer')->id),],
                'company_type' => ['required','digits_between:1,2'],
                'name' => ['required','string','max:30',
                            Rule::unique('customers')->where(function($query){
                                return $query->where('company_type',$this->input('company_type'));
                            })->ignore($this->route('customer')->id),],
                'kana' => ['required','regex:/^[ぁ-ん]+$/','max:30'],
                'tel' => ['required', 'string', 'regex:/\A0\d{9,10}\z/'],
                'zip' => ['required','digits:7'],
                'address' => ['required','string','max:50'],
                'claim_zip' => ['nullable','digits:7'],
                'claim_address' => ['nullable','string','max:50'],
                'invoice_date' => ['required','integer'],
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
