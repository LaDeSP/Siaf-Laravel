<?php

namespace App\Http\Requests;

use App\Models\Produto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class EstoqueFormRequest extends FormRequest{
    public function authorize(){
        /*Descriptografa o id do produto que vem do form*/
        try {
            $this->produto = decrypt($this->produto);
            $produto = Produto::where('id', $this->produto)->first();
            return $produto && $this->user()->can('view-produto', $produto);
        /*Caso alguém altere o hash do id*/
        } catch (DecryptException $e) {
            abort(404);
        }
    }
    
    public function rules(){
        return [
            'produto'      =>  'required',
            'quantidade'     =>  'required|integer|min:1',
            'data_estoque'     =>  'required',
        ];
    }
    
    public function messages(){
        return [
            'produto.required' => 'Produto é um campo obrigatório!',
            'quantidade.required'   => 'Quantidade é um campo obrigatório!',
            'quantidade.integer'     =>  'Quantidade deve ser um número inteiro!',
            'quantidade.min'     =>  'Quantidade deve ser maior que zero!',
            'data_estoque.required' => 'Data do estoque é um campo obrigatório!',
        ];
    }
}
