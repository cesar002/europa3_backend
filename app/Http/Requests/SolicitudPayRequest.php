<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudPayRequest extends FormRequest
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
			'montoTotal' => 'required|numeric',
			'adicionales' => 'present|array',
			'adicionales.*.adicional_id' => 'required|exists:adicionales,id',
			'adicionales.*.cantidad' => 'required|numeric|min:1',
			'deviceId' => 'required',
			'token_data' => 'required',
        ];
    }
}
