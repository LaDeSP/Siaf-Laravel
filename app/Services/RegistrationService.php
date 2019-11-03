<?php
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use App\Services\PropriedadeService;

class RegistrationService{
    protected $userService;
    protected $propriedadeService;
    
    public function __construct(UserService $user, PropriedadeService $propriedade){
        $this->userService = $user;
        $this->propriedadeService = $propriedade;
    }
    
    public function create(array $attributes){
        /*Cria usuario*/
        $user = $this->userService->create($attributes);
        if($user['cpf']){
            $attributesPropriedade['users_id']= $user->id;
            $attributesPropriedade['nome']= $attributes['nome']; 
            $attributesPropriedade['localizacao']= $attributes['localizacao']; 
            $attributesPropriedade['cidade_id']= $attributes['cidade'];
            /*Cria propriedade*/
            $propriedade = $this->propriedadeService->create($attributesPropriedade);
            if($propriedade){
                return $user;
            }else{
                return $data=[
                    'mensagem' => 'Erro ao cadastrar conta, tente novamente!',
                    'class' => 'danger'
                ];
            }
        }else{
            return $user;
        }        
    }
}