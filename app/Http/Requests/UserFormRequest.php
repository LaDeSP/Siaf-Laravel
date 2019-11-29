<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        if($this->senha){
            return [
                'senha' => 'min:6|required',
                'confirme_senha' => 'min:6|same:senha'
            ];
        }else if($this->email){
            return [
                'email' => 'max:100',
            ];
        }else if($this->telefone){
            return [
                'telefone' => 'celular_com_ddd',
            ];
        }else{
            return [
                'name' => ['required', 'string', 'max:255'],
                'nome' =>'required',
                'localizacao' =>'required',
                'cidade' =>'required'
            ];
        }
    }

    public function messages(){
        return [
            'cpf.required' => 'CPF é obrigatório!', 
            'cpf.cpf' => 'CPF inválido!', 
            'cpf.unique' => 'Este CPF já está em uso!', 
            'name.required' => 'Nome é obrigatório!', 
            'name.string' => 'Nome deve conter somenete letras!', 
            'email.unique' => 'Este email já está em uso!',
            'telefone.celular_com_ddd' => 'Telefone inválido!',  
            'senha.required' => 'Senha é obrigatório!', 
            'senha.min' => 'Senha deve ter no mínimo 6 caracteres!', 
            'confirme_senha.same' => 'A senha deve ser igual!', 
            'confirme_senha.min' => 'Senha deve ter no mínimo 6 caracteres!', 
            'nome.required' => 'Nome é obrigatório!', 
            'localizacao.required' => 'Localização é obrigatório!', 
            'cidade.required' => 'Cidade é obrigatório!', 
        ];
    }
}
