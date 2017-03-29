<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChamadaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_inicio' => 'required',
            'data_fim' => 'required',
            'nome_requeridor' => 'required',
            'usuarios' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'max' => 'O campo :attribute excedeu o valor máximo de caracteres.',
        ];
    }
}
