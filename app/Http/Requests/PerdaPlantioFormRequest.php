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
        /*Caso ele não tenha quantidade suficiente para perda e mesmo assim insista em adicionar um valor*/
        if($this->quantidadePlantio == 0){
            return [
                'destino.required' => 'Destino é um campo obrigatório!',
                'quantidade_perda.required' => 'Destino é um campo obrigatório!',
                'quantidade_perda.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
                'quantidade_perda.min'     =>  'Quantidade deve ser maior que zero!',
                'quantidade_perda.max'     =>  'Você não possui quantidade suficiente para perda deste plantio!',
                'data_perda.required' => 'Data da perda é um campo obrigatório!',
            ];
        }else{
            return [
                'destino.required' => 'Destino é um campo obrigatório!',
                'quantidade_perda.required' => 'Destino é um campo obrigatório!',
                'quantidade_perda.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
                'quantidade_perda.min'     =>  'Quantidade deve ser maior que zero!',
                'quantidade_perda.max'     =>  'Quantidade de perda deve ser menor ou igual a '.$this->quantidadePlantio.'!',
                'data_perda.required' => 'Data da perda é um campo obrigatório!',
            ];
        }
    }
}
