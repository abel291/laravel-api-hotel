<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Step4Filanize extends FormRequest
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
            'room_id' => 'Habitacion',
            'client.name' => 'Nombre',
            'client.phone' => 'Telefono',
            'client.country' => 'Pais',
            'client.city' => 'Ciudad',
            'client.email' => 'Correo',
            'client.check_in' => 'Hora de llegada',
            'client.special_request' => 'Peticion especial',
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
            'methodpayment' => 'required|string|max:255',
            'client.name' => 'required|string|max:255',
            'client.phone' => 'required|string|max:255',
            'client.country' => 'required|string|max:255',
            'client.city' => 'required|string|max:255',
            'client.email' => 'required|email|max:255|confirmed',
            'client.check_in' => 'nullable|string|max:255',
            'client.special_request' => 'nullable|string|max:1000',
            'code' => 'sometimes|required|exists:discounts,code',
        ];
    }
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {

    //         if ( session()->missing('start_date') ){
                
    //             $validator->errors()->add('session', 'Al parecer hubo un error!');
            
    //         }

    //     });
    // }
}
