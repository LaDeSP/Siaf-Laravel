<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManejoFormRequest extends FormRequest{
    
    public function authorize(){
        $plantio = $this->route('plantio');
        if($plantio){
            return $plantio && $this->user()->can('view-manejos-plantio', $plantio);
        }else{
            return true;
        }
    }

    public function rules(){
        return [
            'manejo'      =>  'required',
            'horas_utilizadas'     =>  'required|integer|min:1',
            'data_manejo'     =>  'required',
        ];
    }

    public function messages(){
        return [
            'manejo.required' => 'Manejo é um campo obrigatório!',
            'horas_utilizadas.required'   => 'Horas utilizadas é um campo obrigatório!',
            'horas_utilizadas.integer'     =>  'Horas utilizadas deve ser um número inteiro!',
            'horas_utilizadas.min'     =>  'Horas utilizadas deve ser maior que zero!',
            'data_manejo.required' => 'Data do manejo é um campo obrigatório!',
        ];
    }
}
