<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'        => 'required',
            'username'        => 'required|max:255|unique:users',
            'email'         => 'max:255|unique:users',
            'password'         => 'required||min:6|confirmed',
            'image'        => 'mimes:jpg,jpeg,bmp,png',
        ];

        switch($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['roll_number'] = 'required|unique:students,roll_number,' . $this->route('user');
                break;
        }

        return $rules;
    }
}
