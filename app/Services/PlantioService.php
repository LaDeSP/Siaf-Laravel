<?php
namespace App\Services;

use Illuminate\Http\Request;

class PlantioService{
    
    public function __construct(){
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