<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Services\PropriedadeService;

class RegistrationService
{
    protected $userService;
    protected $propriedadeService;

    public function __construct(UserService $user, PropriedadeService $propriedade){
        $this->userService = $user;
        $this->propriedadeService = $propriedade;
    }
    
    public function create(array $data){
        $attributesUser = [];
        $attributesPropriedade = [];
        $attributesUser['cpf'] = preg_replace("/[^0-9]/", "", $data['cpf']);
        $attributesUser['name'] = $data['name'];
        $attributesUser['email'] = $data['email'];
        $attributesUser['password'] = Hash::make($data['senha']);
        $attributesUser['telefone']= $data['telefone']; 
        $attributesPropriedade['users_id']= $attributesUser['cpf'];
        $attributesPropriedade['nome']= $data['nome']; 
        $attributesPropriedade['localizacao']= $data['localizacao']; 
        $attributesPropriedade['cidade_id']= $data['cidade'];  
        $user = $this->userService->create($attributesUser);
        $propriedade = $this->propriedadeService->create($attributesPropriedade);
        return $user;
    }
}