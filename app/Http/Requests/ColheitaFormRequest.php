<?php

namespace App\Http\Requests;

use App\Services\PlantioService;
use Illuminate\Foundation\Http\FormRequest;

class ColheitaFormRequest extends FormRequest{
    protected $plantioService;
    protected $manejo;
    protected $quantidadePlantio;
    
    public function __construct(PlantioService $plantioService){
        $this->plantioService = $plantioService;
    }

    public function authorize(){
        return true;
    }

    public function rules(){
        $this->manejo = $this->route('manejo');
        if($this->manejo->plantio()->first()->produto()->first()->tipo == "c_temporaria"){
            $this->quantidadePlantio = $this->plantioService->novaQuantidadePlantio($this->manejo->plantio()->first());
            return [
                'produto'      =>  'required',
                'quantidade'     =>  'required|integer|min:1|max:'.$this->quantidadePlantio,
                'data_manejo'     =>  'required',
            ];
        }else{
            return [
                'produto'      =>  'required',
                'quantidade'     =>  'required|integer|min:1',
                'data_manejo'     =>  'required',
            ];
        }
    }

    public function messages(){
        if($this->manejo->plantio()->first()->produto()->first()->tipo == "c_temporaria"){
            return [
                'produto.required' => 'Produto é um campo obrigatório!',
                'quantidade.required' => 'Quantidade é um campo obrigatório!',
                'quantidade.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
                'quantidade.min'     =>  'Quantidade de colheita deve ser maior que zero!',
                'quantidade.max'     =>  'Quantidade de colheita deve ser menor ou igual a '.$this->quantidadePlantio.'!',
                'data_manejo.required' => 'Data do manejo é um campo obrigatório!',
            ];
        }else{
            return [
                'produto.required' => 'Produto é um campo obrigatório!',
                'quantidade.required' => 'Quantidade é um campo obrigatório!',
                'quantidade.integer'     =>  'Quantidade de colheita deve ser um número inteiro!',
                'quantidade.min'     =>  'Quantidade deve ser maior que zero!',
                'data_manejo.required' => 'Data do manejo é um campo obrigatório!',
            ];
        }
        
    }
}
