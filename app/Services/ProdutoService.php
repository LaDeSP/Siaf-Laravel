<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\UserService;

class ProdutoService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function create(array $attributes){
        //return $this->propriedadeRepository->create($attributes);
    }
    
    public function read($id){
        //return $this->propriedadeRepository->find($id);
    }
    
    public function update(Request $request, $id){
    }

    public function delete($id){
    }

    public function produtosPropriedadeUser(){
        return $this->userService->propriedadesUser()->produtos()->get();
    }
}