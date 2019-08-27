<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\UserService;
use \Illuminate\Support\Arr;

class VendaService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        $estoques = $this->userService->propriedadesUser()->estoques()->has('vendas')->get();
        $vendas = [];
        foreach($estoques as $key => $estoque){
            array_push($vendas, $estoque->vendas);
        }
        return Arr::collapse($vendas);
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