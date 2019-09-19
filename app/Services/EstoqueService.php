<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\UserService;
use \Illuminate\Support\Arr;

class EstoqueService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function estoquePlataveisIndex(){
        $estoquesProdutosPlantaveis =  $this->userService->propriedadesUser()->estoques()->get();
        $estoques = [];

        foreach($estoquesProdutosPlantaveis as $estoque){
            if($estoque->produto()->whereIn("tipo", ["c_permanente","c_temporaria"])->first()){
                array_push($estoques, $estoque);
            }
        }
        return $estoques;
    }

    public function estoqueProcessadoIndex(){
        $estoquesProdutosPropriedade =  $this->userService->propriedadesUser()->estoques()->get();
        $estoques = [];

        foreach($estoquesProdutosPropriedade as $key => $estoque){
            if($estoque->produto()->where("tipo","processado")->first()){
                array_push($estoques, $estoque);
            }
        }
        return $estoques;
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
}