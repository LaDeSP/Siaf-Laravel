<?php

namespace App\Http\Controllers\Auth;

use App\Models\Estado;
use App\Http\Controllers\Controller;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller{
    use RegistersUsers;
    protected $redirectTo = '/home';
    protected $registerService;
    
    public function __construct(RegistrationService $register){
        $this->middleware('guest');
        $this->registerService = $register;
    }
    
    protected function validator(array $data){
        $messages = $this->messages(); 
        $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);  
        return Validator::make($data, [
            'cpf' => 'required|cpf|unique:users',
            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:100',
            'senha' => 'min:6|required',
            'confirme_senha' => 'min:6|same:senha',
            'nome' =>'required',
            'localizacao' =>'required',
            'cidade' =>'required'
        ], $messages);
    }
    
    protected function messages(){
        return [
            'cpf.required' => 'CPF é obrigatório!',
            'cpf.cpf' => 'CPF inválido!',
            'cpf.unique' => 'Este CPF já está em uso!',
            'name.required' => 'Nome é obrigatório!',
            'name.string' => 'Nome deve conter somenete letras!',
            'email.unique' => 'Este email já está em uso!',
            'senha.required' => 'Senha é obrigatório!',
            'senha.min' => 'Senha deve ter no mínimo 6 caracteres!',
            'confirme_senha.same' => 'A senha deve ser igual!',
            'confirme_senha.min' => 'Senha deve ter no mínimo 6 caracteres!',
            'nome.required' => 'Nome é obrigatório!',
            'localizacao.required' => 'Localização é obrigatório!',
            'cidade.required' => 'Cidade é obrigatório!',
        ];
    }
    
    public function showRegistrationForm(){
        $estados = Estado::orderBy('nome')->get();
        return view('auth.register', ['estados'=>$estados]);
    }
    
    protected function create(array $data){
        return $this->registerService->create($data);
    }
}            
