<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudVisitaRequest extends FormRequest
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
			'id_oficina' => 'required|numeric',
			'tipo_oficina' => 'required|numeric',
            'nombre' => 'required',
			'email' => 'required|email',
			'telefono' => 'required',
			'comentario' => 'nullable',
        ];
    }
}
