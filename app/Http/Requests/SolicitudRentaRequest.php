<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRentaRequest extends FormRequest
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
			'user_id' => 'required|exists:users,id',
			'oficina_id' => 'required|exists:oficinas,id',
			'metodo_pago_id' => 'required|exists:cat_metodos_pago,id',
			'meses_renta' => 'required|integer|min:1',
			'numero_ocupantes' => 'required|integer|min:1'
        ];
    }
}
