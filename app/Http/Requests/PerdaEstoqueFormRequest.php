<?php

namespace App\Http\Requests;

use App\Services\EstoqueService;
use Illuminate\Foundation\Http\FormRequest;

class PerdaEstoqueFormRequest extends FormRequest{
    protected $estoqueService;
    protected $quantidadeEstoque;
    
    public function __construct(EstoqueService $estoqueService){
        $this->estoqueService = $estoqueService;
    }

    public function authorize(){
        return true;
    }

    public function rules(){
        $estoque = $this->route('estoque');
        $this->quantidadeEstoque = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($estoque);
        return [
            'destino'      =>  'required',
            'quantidade_perda'     =>  'required|integer|min:1|max:'.$this->quantidadeEstoque,
            'data_perda'     =>  'required',
        ];
    }

    public function messages(){
        return [
            'destino.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.required' => 'Destino é um campo obrigatório!',
            'quantidade_perda.integer'     =>  'Quantidade de perda deve ser um número inteiro!',
            'quantidade_perda.min'     =>  'Horas utilizadas deve ser maior que zero!',
            'quantidade_perda.max'     =>  'Quantidade de perda deve ser menor ou igual a '.$this->quantidadeEstoque.'!',
            'data_perda.required' => 'Data da perda é um campo obrigatório!',
        ];
    }
}
