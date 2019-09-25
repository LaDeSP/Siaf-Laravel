<?php

namespace App\Http\Requests;

use App\Services\PlantioService;
use Illuminate\Foundation\Http\FormRequest;

class PerdaPlantioFormRequest extends FormRequest{
    
    protected $plantioService;
    
    public function __construct(PlantioService $plantioService){
        $this->plantioService = $plantioService;
    }

    public function authorize(){
        return true;
    }

    public function rules(){
        $plantio = $this->route('plantio');
        $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        return [
            'destino'      =>  'required',
            'quantidade_perda'     =>  'required|integer|min:1|max:'.$plantio->quantidade_pantas,
            'data_perda'     =>  'required',
        ];
    }

    public function messages(){
        $plantio = $this->route('plantio');
        return [
            'destino.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
            'quantidade_perda.min'     =>  'Horas utilizadas deve ser maior que zero!',
            'quantidade_perda.max'     =>  'Quantidade de perda deve ser menor ou igual a '.$plantio->quantidade_pantas.'!',
            'data_perda.required' => 'Data do manejo é um campo obrigatório!',
        ];
    }
}
