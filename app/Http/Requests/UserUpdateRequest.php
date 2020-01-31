<?php

namespace App\Http\Requests;

class UserUpdateRequest extends Request
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
        $rules = [
            'name'     => 'required',
            'username'    => 'string|required|unique:users,username,' . $this->route("user"),
            'email'    => 'email|nullable|unique:users,email,' . $this->route("user"),
            'password' => 'required_with:password_confirmation|confirmed',
            'staff_id'     => 'required',

            'file'=>'max:1024',
            'image'=>'mimes:jpg,jpeg,bmp,png|max:1024',
        ];

        return $rules;
    }
}
