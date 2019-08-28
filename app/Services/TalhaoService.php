<?php

namespace App\Services;

use App\Repositories\TalhaoRepository;
use Illuminate\Http\Request;
use App\Services\UserService;

class TalhaoService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        return $this->userService->propriedadesUser()->talhoes()->get();
    }
    
    public function create(Request $request){
        $attributes = $request->all();
        return $this->talhaoRepository->create($attributes);
    }
    
    public function read($id){
        return $this->talhaoRepository->find($id);
    }

    public function readPlantioTalhao($idTalhao){
        return $this->talhaoRepository->findPlantioTalhao($idTalhao);
    }
    
    public function update(Request $request, $id){
        $attributes = $request->all();
        return $this->talhaoRepository->update($id, $attributes);
    }
    
    public function delete($id){
        return $this->talhaoRepository->delete($id);
    }
}