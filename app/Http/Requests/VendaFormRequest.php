<?php

namespace App\Http\Requests;

use App\Models\Estoque;
use App\Services\EstoqueService;
use Illuminate\Foundation\Http\FormRequest;

class VendaFormRequest extends FormRequest{
    protected $estoqueService;
    protected $quantidadeEstoque;
    
    public function __construct(EstoqueService $estoqueService){
        $this->estoqueService = $estoqueService;
    }

    public function authorize(){
        return true;
    }
   
    public function rules(){
        $this->estoque = Estoque::findBySlugOrFail($this->estoque);
        $this->quantidadeEstoque = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($this->estoque);
        return [
            'estoque'      =>  'required',
            'destino'      =>  'required',
            'quantidade_venda'     =>  'required|integer|min:1|max:'.$this->quantidadeEstoque,
            'valor_unit'     =>  'required|between:0,99.99',
            'data_venda'     =>  'required',
        ];
    }

    public function messages(){
        /*Caso ele não tenha quantidade suficiente para venda e mesmo assim insista em adicionar um valor*/
        if($this->quantidadeEstoque == 0){
            return [
                'estoque.required' => 'Estoque é um campo obrigatório!',
                'destino.required' => 'Destino é um campo obrigatório!',
                'quantidade_venda.required' => 'Quantidade é um campo obrigatório!',
                'quantidade_venda.integer'     =>  'Quantidade da venda deve ser um número inteiro!',
                'quantidade_venda.min'     =>  'Quantidade deve ser maior que zero!',
                'quantidade_venda.max'     =>  'Você não possui quantidade suficiente para venda deste estoque!',
                'data_venda.required' => 'Data da venda é um campo obrigatório!',
                'valor_unit.required' => 'O valor é um campo obrigatório!',
                'valor_unit.between' => 'O valor deve ser um número!',
            ];
        }else{
            return [
                'estoque.required' => 'Estoque é um campo obrigatório!',
                'destino.required' => 'Destino é um campo obrigatório!',
                'quantidade_venda.required' => 'Quantidade é um campo obrigatório!',
                'quantidade_venda.integer'     =>  'Quantidade da venda deve ser um número inteiro!',
                'quantidade_venda.min'     =>  'Quantidade deve ser maior que zero!',
                'quantidade_venda.max'     =>  'Quantidade da venda deve ser menor ou igual a '.$this->quantidadeEstoque.'!',
                'data_venda.required' => 'Data da venda é um campo obrigatório!',
                'valor_unit.required' => 'O valor é um campo obrigatório!',
                'valor_unit.between' => 'O valor deve ser um número!',
            ];
        }
    }
}
