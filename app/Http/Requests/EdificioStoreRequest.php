<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EdificioStoreRequest extends FormRequest
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
			'nombre' => 'required',
			'direccion' => 'required',
			'municipio_id' => 'required|exists:municipios,id',
			'telefono' => 'required|numeric',
			'telefono_recepcion' => 'required|numeric',
			'hora_apertura' => 'required',
			'hora_cierre' => 'required',
			'idiomas_atencion' => 'required|array',
        ];
    }
}
