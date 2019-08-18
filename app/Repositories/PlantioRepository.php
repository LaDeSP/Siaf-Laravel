<?php
namespace App\Repositories;

use App\Models\Plantio;

class PlantioRepository
{
    protected $plantio;
    
    public function __construct(Plantio $plantio){
        $this->plantio = $plantio;
    }
    
    public function create($attributes){
        return $this->plantio->create($attributes);
    }
    
    public function all(){
        return $this->plantio->all();
    }
    
    public function find($id){
        return $this->plantio->find($id);
    }

    public function plantioFindUser($cpf){
        return $this->plantio->plantioByUser($cpf);
    }
    
    public function update($id, array $attributes){
        return $this->plantio->find($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->plantio->find($id)->delete();
    }
}