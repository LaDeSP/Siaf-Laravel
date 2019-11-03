<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller{
    
    public function edit(User $user){
        $usuario = $this->usuario;
        return view('painel.users.edit', ['user'=>auth()->user()]);
    }
    
    public function update(Request $request){
        $user = $this->usuario;
        
        $data = $request->all();

        $validacao = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:100',
            ]);
        
        if($validacao->fails())
        {
            return view('user', ["User"=>$this->getFirstName($this->usuario['name']), 'errors'=>$validacao->errors(), "usuario"=>$user,"Tela"=>"Meu Perfil"]);
        }else if(!$data['telefone'] == '')
        {
            $validacao = Validator::make($data, [
                'telefone' =>'celular_com_ddd',
                ]);
                if($validacao->fails())
                {
                    return view('user', ["User"=>$this->getFirstName($this->usuario['name']), 'errors'=>$validacao->errors(), "usuario"=>$user,"Tela"=>"Meu Perfil"]);
                } 
        }else if (!$data['senha'] == '')
        {
            $validacao = Validator::make($data, [
                'senha' => 'min:6',
                'confirme_senha' => 'min:6|same:senha',
                ]);
                if($validacao->fails())
                {
                    return view('user', ["User"=>$this->getFirstName($this->usuario['name']), 'errors'=>$validacao->errors(), "usuario"=>$user,"Tela"=>"Meu Perfil"]);
                }    
            $user->password = bcrypt($data['senha']);
        }

        $salva=$user->update($data);
        if($salva==true)
        {
            $status='success';
            $mensagem='Sucesso ao editar perfil!';
        }
        else
        {
            $status='danger';
            $mensagem='Erro ao editar perfil!';
        }
        
        return view('user', ["User"=>$this->getFirstName($this->usuario['name']), "usuario"=>$user,"Tela"=>"Meu Perfil", 'mensagem'=>$mensagem,'status'=>$status]);
    }
}
