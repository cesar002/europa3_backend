<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdicionalesRequest extends FormRequest
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
			'edificio_id' => 'required|exists:edificios,id',
			'unidad_id' => 'required|exists:cat_unidad_adicional,id',
			'nombre' => 'required|string',
			'precio' => 'required|numeric|min:0',
			'cantidad_maxima' => 'required|integer|min:1',
        ];
    }

	public function attributes()
	{
		return [
			'edificio_id' => 'edificio',
			'unidad_id' => 'unidad',
		];
	}
}
