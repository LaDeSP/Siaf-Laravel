<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoFormRequest extends FormRequest{
   
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'nome_produto'      =>  'required|max:255',
            'unidade'     =>  'required',
            'categoria'     =>  'required',
        ];
    }

    public function messages(){
        return [
            'nome_produto.required'     => 'Nome do produto é um campo obrigatório!',
            'unidade.required' => 'Unidade do produto é um campo obrigatório!',
            'categoria.required' => 'Categoria do produto é um campo obrigatório!'
        ];
    }
}
