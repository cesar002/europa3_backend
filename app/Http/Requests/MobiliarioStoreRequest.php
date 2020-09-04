<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobiliarioStoreRequest extends FormRequest
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
			'tipo_id' => 'required|exists:tipos_mobiliario,id',
			'edificio_id' => 'required|exists:edificios,id',
			'marca' => 'required',
			'color' => 'required',
			'cantidad' => 'required|integer|min:1'
        ];
    }
}
