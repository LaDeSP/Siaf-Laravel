<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\UserService;
use \Illuminate\Support\Arr;

class ManejoService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        $talhoes = $this->userService->propriedadesUser()->talhoes()->get();
        $plantios = [];
        foreach($talhoes as $talhao){
            if($talhao->plantios()){
                array_push($plantios, $talhao->plantios);
            }
        }
        return Arr::collapse($plantios);
    }
    
    public function create(array $attributes){
        //return $this->propriedadeRepository->create($attributes);
    }
    
    public function read($plantio){
        $manejos = $plantio->manejos()->get();
        //dd($manejos);
        if($manejos->isEmpty()){
            return collect([]);
        }else{
            return $manejos;
        }
    }
    
    public function update(Request $request, $id){
    }
    
    public function delete($id){
    }
}