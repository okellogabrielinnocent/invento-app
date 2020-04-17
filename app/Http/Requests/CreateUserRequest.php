<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin() || auth()->user()->is_data_clerk();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:25|unique:users',
            'email' => 'bail|required|email:rfc,dns,filter,spoof,strict|unique:users',
            'password' => 'required|min:8|max:25|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required | string',
        ];
    }
}
