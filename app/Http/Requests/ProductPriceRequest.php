<?php

namespace App\Http\Requests;

use App\Http\Enumerations\PriceType;
use Illuminate\Foundation\Http\FormRequest;

class ProductPriceRequest extends FormRequest
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
            'price' => 'required|min:0|numeric',
            'product_id' => 'required|exists:products,id',
            'special_price' => 'nullable|numeric',
            'special_price_type' => 'required_with:special_price|in:'.PriceType::Percent.','.PriceType::Fixed,
            'special_price_start' => 'required_with:special_price|date_format:Y-m-d',
            'special_price_end' => 'required_with:special_price|date_format:Y-m-d',




        ];
    }


    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'required_with'=>__('admin/validation.required'),
            'numeric'=>__('admin/validation.numeric2s'),
            'exists'=>__('admin/validation.exists'),
            'min'=>__('admin/validation.min2'),
            'special_price_type.in'=>__('admin/validation.choose1'),
            'date_format'=>__('admin/validation.date'),



        ];
    }
}
