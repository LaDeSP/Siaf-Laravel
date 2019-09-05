<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantioFormRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'data_plantio'      =>  'required',
            'numero_plantas'     =>  'required|integer|min:1',
            'talhao'     =>  'required',
            'produto'     =>  'required'
        ];
    }

    public function messages(){
        return [
            'data_plantio.required'   => 'Data do plantio é um campo obrigatório!',
            'numero_plantas.required' => 'Número de plantas é um campo obrigatório!',
            'numero_plantas.integer'     =>  'Número de plantas deve ser um número inteiro!',
            'numero_plantas.min'     =>  'Número de plantas deve ser maior que zero!',
            'talhao.required' => 'Talhão é um campo obrigatório!',
            'produto.required' => 'Produto é um campo obrigatório!'
        ];
    }
}
