<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudOficinaRequest extends FormRequest
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
			'tipo_oficina' => 'required|exists:cat_tipos_oficina,id',
			'id' => 'required',
			'fecha_reservacion' => 'required',
			'meses_renta' => 'present',
			'hora_inicio' => 'present',
			'hora_fin' => 'present',

        ];
    }
}
