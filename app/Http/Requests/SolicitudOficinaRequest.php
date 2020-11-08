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
			'oficina_id' => 'required|exists:oficinas,id',
			'fecha_reservacion' => 'required|date',
			'meses_renta' => 'required|integer|min:6',
			'numero_integrantes' => 'nullable|integer',
        ];
    }
}
