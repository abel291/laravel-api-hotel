<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Step3Confirmation extends FormRequest
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
    public function attributes()
    {
        return [
            // //step1
            // 'start_date' => 'Fecha de Inicio',
            // 'end_date' => 'Fecha de Salida',
            // 'adults' => 'Adultos',
            // 'kids' => 'Niños',

            //step3
            'room_id' => 'Habitacion',
            'room_quantity' => 'Cantidad de habitaciones',
            'code' => 'Codigo de descuento',

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // //step1
            // 'start_date' => 'required|date_format:Y-m-d|before:end_date',
            // 'end_date' => 'required|date_format:Y-m-d|after:start_date',
            // 'adults' => 'required|min:1',
            // 'kids' => 'required|min:1',

            //step3
            'room_id' => 'required|exists:rooms,id',
            'room_quantity' => 'required|numeric',
            'code' =>
            [
                'sometimes',
                'required',
                Rule::exists('discounts', 'code')->where(function ($query) {
                    $query->where('active', 1);
                }),
            ],

        ];
    }
}
