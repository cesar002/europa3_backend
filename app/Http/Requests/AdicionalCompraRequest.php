<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdicionalCompraRequest extends FormRequest
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
			'solicitud_id' => 'required|exists:solicitud_reservacion,id',
			'folio_pago' => 'required',
			'adicionales' => 'required|array',
			'adicionales.*.adicional_id' => 'required|exists:adicionales,id',
			'adicionales.*.cantidad' => 'required|integer|min:1'
        ];
    }
}
