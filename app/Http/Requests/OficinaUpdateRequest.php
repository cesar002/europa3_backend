<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OficinaUpdateRequest extends FormRequest
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
			'tipo_oficina_id' => 'required|exists:cat_tipos_oficina,id',
			'size_id' => 'required|exists:cat_size_oficinas,id',
			'nombre' => 'required',
			'descripcion' => 'required',
			'precio' => 'required|numeric',
			'capacidad_recomendada' => 'required|numeric|min:1',
			'capacidad_maxima' => 'required|numeric|min:1|gte:capacidad_recomendada',
        ];
    }
}
