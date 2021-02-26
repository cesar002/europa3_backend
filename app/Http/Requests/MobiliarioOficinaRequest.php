<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobiliarioOficinaRequest extends FormRequest
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
			'oficina_id' => 'required|exists:oficinas,id',
			'mobiliario_id' => 'required|exists:mobiliarios,id',
        ];
    }
}
