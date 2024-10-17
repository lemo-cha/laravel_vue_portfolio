<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
                'custom_id' => ['required','unique:units,custom_id','string','regex:/^[0-9]+$/','size:2'],
                'name' => ['required','unique:units,name','string','max:4'],
            ];
        }else if($this->isMethod('patch')){
            return [
                'custom_id' => ['required','unique:units,custom_id,' . $this->unit->id,'string','regex:/^[0-9]+$/','size:2'],
                'name' => ['required','unique:units,name,' . $this->unit->id,'string','max:4'],
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'name' => '単位名',
        ];
    }
}
