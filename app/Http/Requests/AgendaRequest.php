<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendaRequest extends FormRequest
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
            'fecha_actividad' => 'required|date',
			'hora_inicio' => 'present|nullable',
			'hora_fin' => 'present|nullable',
			'titulo' => 'required|string',
        ];
    }
}
