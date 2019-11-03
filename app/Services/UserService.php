<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService{
    
    public function create(array $attributes){
        try {
            $attributes['cpf'] = preg_replace("/[^0-9]/", "", $attributes['cpf']);
            $saved =  User::create([
                'cpf' => $attributes['cpf'],
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['senha']),
                'telefone' =>$attributes['telefone'],
                ]);
            if($saved){
                return $saved;
            }else{
                return $data=[
                    'mensagem' => 'Erro ao cadastrar conta, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao cadastrar conta, tente novamente!',
                'class' => 'danger'
            ];
        }
    }

    public function update(Request $request, $id){
        $attributes = $request->all();  
        return $this->userRepository->update($id, $attributes);
    }

    public function propriedadesUser(){
        return auth()->user()->propriedades()->first();
    }
}