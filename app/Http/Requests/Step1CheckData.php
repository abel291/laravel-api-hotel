<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Step1CheckData extends FormRequest
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
            'start_date' => 'Fecha de Inicio',
            'end_date' => 'Fecha de Salida',
            'adults' => 'Adultos',
            'kids' => 'Niños',
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
            'start_date' => 'required|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date_format:Y-m-d|after:start_date',
            'adults' => 'required|min:1',
            'kids' => 'required|min:1',
        ];
    }
}
