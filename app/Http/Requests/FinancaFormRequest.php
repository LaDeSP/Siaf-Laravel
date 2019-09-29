<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancaFormRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }
    
    public function rules(){
        if($this->investimento){
            return [
                'investimento'      =>  'required',
                'quantidade'     =>  'required|integer|min:1',
                'valor_investimento'     =>  'required|between:0,99.99',
                'data_investimento'     =>  'required',
            ];
        }else{
            return [
                'despesa'      =>  'required',
                'quantidade'     =>  'required|integer|min:1',
                'valor_despesa'     =>  'required|between:0,99.99',
                'data_despesa'     =>  'required',
            ];
        }
    }
    
    public function messages(){
        if($this->investimento){
            return [
                'investimento.required' => 'Investimento é um campo obrigatório!',
                'quantidade.required' => 'Quantidade de itens é obrigatório!',
                'quantidade.integer'     =>  'Quantidade de itens deve ser um número inteiro!',
                'quantidade.min'     =>  'Quantidade de itens deve ser maior que zero!',
                'valor_investimento.required' => 'O valor do investimento é um campo obrigatório!!',
                'valor_investimento.between' => 'O valor do investimento deve ser um número!',
                'data_investimento.required' => 'Data do investimento é um campo obrigatório!',
            ];
        }else{
            return [
                'despesa.required' => 'Despesa é um campo obrigatório!',
                'quantidade.required' => 'Quantidade de itens é obrigatório!',
                'quantidade.integer'     =>  'Quantidade de itens deve ser um número inteiro!',
                'quantidade.min'     =>  'Quantidade de itens deve ser maior que zero!',
                'valor_despesa.required' => 'O valor da despesa é um campo obrigatório!!',
                'valor_despesa.between' => 'O valor da despesa deve ser um número!',
                'data_despesa.required' => 'Data da despesa é um campo obrigatório!',
            ];
        }
    }
    
}
