<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price'=>'required|numeric|min:0',
            'name'=>'required|max:100',
            'product_id'=>'required|exists:products,id',
            'attribute_id'=>'required|exists:attributes,id',
        ];
    }

    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'name.max'=>__('admin/validation.nmax'),

        ];
    }
}
