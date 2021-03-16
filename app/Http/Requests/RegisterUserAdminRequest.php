<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserAdminRequest extends FormRequest
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
			'username' => 'required|unique:users_admin,username',
			'password' => 'required|confirmed|min:5',
			'nombre' => 'required',
			'ap_p' => 'required',
			'ap_m' => 'required',
			'avatar' => 'nullable|image|dimensions:min_width=100,min_height=100|max:1100'
        ];
    }
}
