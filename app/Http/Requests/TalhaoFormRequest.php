<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TalhaoFormRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    
    public function rules(){
        return [
            'nome_talhao'      =>  'required|max:255',
            'area_talhao'     =>  'required|integer|min:1',
        ];
    }

    public function messages(){
        return [
            'nome_talhao.required'     => 'Nome do talhão é um campo obrigatório!',
            'area_talhao.required' => 'Área do talhão é um campo obrigatório!',
            'area_talhao.integer'     =>  'Área do talhão deve ser um número inteiro!',
            'area_talhao.min'     =>  'Área do talhão deve ser maior que zero!',
        ];
    }
}
