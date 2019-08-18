<?php
namespace App\Repositories;

use App\Models\Talhao;

class TalhaoRepository
{
    protected $talhao;
    
    public function __construct(Talhao $talhao){
        $this->talhao = $talhao;
    }
    
    public function create($attributes){
        return $this->talhao->create($attributes);
    }
    
    public function all(){
        return $this->talhao->all();
    }
    
    public function find($id){
        return $this->talhao->find($id);
    }

    public function findPlantioTalhao($idTalhao){
        return $this->talhao->findPlantioTalhao($idTalhao);
    }
    
    public function update($id, array $attributes){
        return $this->plantio->find($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->plantio->find($id)->delete();
    }
}