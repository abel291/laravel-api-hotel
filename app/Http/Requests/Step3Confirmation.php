<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'room_id' => 'Habitacion',
            'room_quantity' => 'Cantidad de habitaciones',
            
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
            'room_id' => 'required|exists:rooms,id',
            'room_quantity' => 'required|numeric',
        ];
    }
    
}
