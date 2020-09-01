<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email'=>'required|email|unique:admins,email,'.$this -> id,
            'name'=>'required',
            'password'=>'nullable|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'required'=>__('admin/validation.required'),
            'email.email'=>__('admin/validation.email'),
            'email.unique'=>__('admin/validation.unique'),
            'password.confirmed'=>__('admin/validation.confirmed'),
            'password.min'=>__('admin/validation.min'),

        ];
    }
}
