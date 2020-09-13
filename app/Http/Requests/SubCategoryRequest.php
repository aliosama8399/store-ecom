<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'parent_id'=>'required|exists:categories,id',
            'name'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'parent_id.exists'=>__('admin/validation.exists1'),
            'slug.unique'=>__('admin/validation.unique1'),

        ];
    }
}
