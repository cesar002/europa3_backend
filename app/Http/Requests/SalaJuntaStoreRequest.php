<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaJuntaStoreRequest extends FormRequest
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
			'tipo_tiempo_id' => 'required|exists:cat_tiempo_renta,id',
			'nombre' => 'required|string',
			'descripcion' => 'required|string',
			'size_dimension' => 'required|string',
			'capacidad_recomendada' => 'required|numeric|min:1',
			'capacidad_maxima' => 'required|numeric|min:1|gte:capacidad_recomendada',
			'precio' => 'required|numeric',
			'mobiliario' => 'required|array',
			'mobiliario.*' => 'required|exists:mobiliarios,id',
			'servicios' => 'required|array',
			'servicios.*' => 'required|exists:cat_servicios_oficina,id',
        ];
    }
}
