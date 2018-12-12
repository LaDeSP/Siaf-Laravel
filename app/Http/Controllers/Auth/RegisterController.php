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

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    use RegistersUsers;
    
    /**
    * Where to redirect users after registration.
    *
    * @var string
    */
    protected $redirectTo = '/home';
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
    protected function validator(array $data)
    {   
        $data['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
        return Validator::make($data, [
            'cpf' => 'required|cpf|unique:users',
            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:100',
            'senha' => 'min:6|required',
            'confirme_senha' => 'min:6|same:senha',
            'telefone' =>'required|celular_com_ddd',
            'nome' =>'required',
            'localizacao' =>'required',
            'cidade' =>'required'
            ]);
        }
        
        /**
        * Create a new user instance after a valid registration.
        *
        * @param  array  $data
        * @return \App\User
        */
        protected function create(array $data)
        {
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
        