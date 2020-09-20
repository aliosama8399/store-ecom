<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            'slug'=>'required|unique:categories,slug,'.$this -> id,
            'name'=>'required',
            'type'=>'required|in:1,2',
        ];
    }

    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'slug.unique'=>__('admin/validation.unique1'),
            'type.in'=>__('admin/validation.choose'),

        ];
    }
}
