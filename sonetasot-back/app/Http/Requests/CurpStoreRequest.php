<?php

namespace App\Http\Requests;

use App\Rules\CurpValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class CurpStoreRequest extends FormRequest
{

    public function rules()
    {
        $listaDeEstados = ['AS', 'BC', 'BS', 'CC', 'CS', 'CH', 'DF', 'CL', 'CM', 'DG', 'GT', 'GR', 'HG', 'JC', 'MC', 'MN', 'MS', 'NT', 'NL', 'OC', 'PL', 'QO', 'QR', 'SP', 'SL', 'SR', 'TC', 'TS', 'TL', 'VZ', 'YN', 'ZS'];

        return [

            'nombre' => 'required',
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'fecha_nacimiento' => 'required|date',
            'sexo' => [
                'required', Rule::in(['M', 'H']),
            ],
            'estado' => [
                'required', Rule::in($listaDeEstados),
            ],
            'curp' => ['required', Rule::unique('curps', 'curp')->ignore($this->id, 'id'), new CurpValidationRule]
        ];

    }



    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success' => false,
            'errors' => $validator->errors(),

        ])->setStatusCode(406));

    }



    public function messages()
    {

        return [
            'nombre.required' => 'El nombre es obligatorio',
            'apellido_p.required' => 'El Apellido Paterno es obligatorio',
            'apellido_m.required' => 'El Apellido Materno es obligatorio',
            'fecha_nacimiento.required' => 'La Fecha de Nacimiento es obligatorio',
            'fecha_nacimiento.date' => 'La Fecha de Nacimiento debe tener un formato valido',
            'sexo.required' => 'El Sexo es obligatorio',
            'sexo.*' => 'El sexo solo debe ser M o H',
            'estado.required' => 'El Estado es obligatorio',
            'estado.*' => 'Abreviatura de estado invalido, ej. Hidalgo es HG',
            'curp.required' => 'El Curp es obligatorio',
            'curp.unique' => 'El Curp ya se ecuentra registrado',
        ];

    }

}