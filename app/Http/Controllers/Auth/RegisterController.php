<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Propriedade;
use App\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use App\Services\RegistrationService;
use Illuminate\Http\Request;


class RegisterController extends Controller{
    use RegistersUsers;
    protected $redirectTo = '/home';
    protected $registerService;
    
    public function __construct(RegistrationService $register){
        $this->middleware('guest');
        $this->registerService = $register;
    }
    
    protected function validator(array $data){   
        return Validator::make($data, [
            'cpf' => 'required|formato_cpf|unique:users',
            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:100|unique:users',
            'senha' => 'min:6|required',
            'confirme_senha' => 'min:6|same:senha',
            'nome' =>'required',
            'localizacao' =>'required',
            'cidade' =>'required'
            ]);
    }
        
    protected function create(array $data){
        $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
            $sucesso =  User::create([
                'cpf' => $data['cpf'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['senha']),
                'telefone' =>$data['telefone'],
                ]);
                Propriedade::inserir($data);
                return $sucesso;
    }
}            
        