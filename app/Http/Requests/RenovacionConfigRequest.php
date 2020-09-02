<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenovacionConfigRequest extends FormRequest
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
			'meses_notificacion' => 'required|integer|min:1',
            'minimo_renovacion' => 'required|integer|min:1',
        ];
    }
}
