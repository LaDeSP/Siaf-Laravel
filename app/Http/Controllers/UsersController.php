<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $usuario = $this->usuario;
        return view('user', ["User"=>$this->getFirstName($this->usuario['name']), "usuario"=>$usuario,"Tela"=>"Meu Perfil"]);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request)
    {
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
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
