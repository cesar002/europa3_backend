<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatosFiscalesStoreRequest extends FormRequest
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
			'email' => 'required|email',
			'razon_social' => 'required',
			'rfc' => ['required', 'regex:/^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/i'],
			'telefono' => 'required|numeric',
			'calle' => 'required',
			'cp' => ['required', 'regex:/^[0-9]{5}$/i'],
			'colonia' => 'required',
			'municipio_id' => 'required|exists:municipios,id',
			'estado_id' => 'required|exists:estados,id',
        ];
    }
}
