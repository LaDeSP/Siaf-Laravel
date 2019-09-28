<?php

namespace App\Http\Requests;

use App\Models\Estoque;
use App\Services\VendaService;
use App\Services\EstoqueService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class VendaFormRequest extends FormRequest{
    protected $vendaService;
    protected $estoqueService;
    protected $quantidadeEstoque;
    protected $vendaEstoque;
    
    public function __construct(VendaService $vendaService, EstoqueService $estoqueService){
        $this->vendaService = $vendaService;
        $this->estoqueService = $estoqueService;
    }

    public function authorize(){
        /*Descriptografa o id do estoque que vem do form*/
        try {
            $this->estoque = decrypt($this->estoque);
            return true;
        /*Caso alguém altere o hash do id*/
        } catch (DecryptException $e) {
            abort(404);
        }
    }

    public function rules(){
        $idEstoque = decrypt($this->estoque);
        $this->vendaEstoque = Estoque::all()->where('id', $idEstoque)->first();
        $this->quantidadeEstoque = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($this->vendaEstoque);
        
        return [
            'estoque'      =>  'required',
            'destino'      =>  'required',
            'quantidade_venda'     =>  'required|integer|min:1|max:'.$this->quantidadeEstoque,
            'valor_unit'     =>  'required|numeric|between:0,99.99',
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
                'valor_unit.between' => 'O valor deve ser um número!'
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
                'valor_unit.between' => 'O valor deve ser um número!'
            ];
        }
    }
}
