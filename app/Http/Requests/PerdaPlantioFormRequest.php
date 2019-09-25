<?php

namespace App\Http\Requests;

use App\Services\PlantioService;
use Illuminate\Foundation\Http\FormRequest;

class PerdaPlantioFormRequest extends FormRequest{
    
    protected $plantioService;
    protected $quantidadePlantio;
    
    public function __construct(PlantioService $plantioService){
        $this->plantioService = $plantioService;
    }

    public function authorize(){
        return true;
    }

    public function rules(){
        $plantio = $this->route('plantio');
        $this->quantidadePlantio = $this->plantioService->novaQuantidadePlantio($plantio);
        return [
            'destino'      =>  'required',
            'quantidade_perda'     =>  'required|integer|min:1|max:'.$this->quantidadePlantio,
            'data_perda'     =>  'required',
        ];
    }

    public function messages(){
        return [
            'destino.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
            'quantidade_perda.min'     =>  'Horas utilizadas deve ser maior que zero!',
            'quantidade_perda.max'     =>  'Quantidade de perda deve ser menor ou igual a '.$this->quantidadePlantio.'!',
            'data_perda.required' => 'Data do manejo é um campo obrigatório!',
        ];
    }
}
