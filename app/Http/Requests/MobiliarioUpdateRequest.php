<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobiliarioUpdateRequest extends FormRequest
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
			'nombre' => 'required',
			'cantidad' => 'required|integer|min:1',
			'image' => 'nullable|image|max:10300'
        ];
    }

	public function attributes()
	{
		return [
			'tipo_id' => 'tipo de mobiliario',
			'edificio_id' => 'edificio',
			'image' => 'imagen'
		];
	}
}
