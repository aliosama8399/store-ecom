<?php

namespace App\Http\Requests;

use App\Http\Enumerations\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
use Spatie\Enum\Laravel\Rules\EnumIndexRule;
use Spatie\Enum\Laravel\Rules\EnumNameRule;
use Spatie\Enum\Laravel\Rules\EnumRule;
use Spatie\Enum\Laravel\Rules\EnumValueRule;

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
            'photo'=>'required_without:id|mimes:jpg,jpeg,png',
            'type'=>'required_without:id|in:'.CategoryType::MainCategory.','.CategoryType::SubCategory,


        ];



    }

    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'slug.unique'=>__('admin/validation.unique1'),
            'type.in'=>__('admin/validation.choose'),
            'type.required_without'=>__('admin/validation.required'),
            'photo.mimes'=>__('admin/validation.photo'),
            'photo.required_without'=>__('admin/validation.required'),

        ];
    }
}
