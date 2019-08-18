<?php
namespace App\Repositories;

use App\Models\Propriedade;

class PropriedadeRepository
{
    protected $propriedade;
    
    public function __construct(Propriedade $propriedade){
        $this->propriedade = $propriedade;
    }
    
    public function create($attributes){
        return $this->propriedade->create($attributes);
    }
    
    public function all(){
        return $this->propriedade->all();
    }
    
    public function find($id){
        return $this->propriedade->find($id);
    }

    public function propriedadeFindUser($cpf){
        return $this->propriedade->propriedadeByUser($cpf);
    }
    
    public function update($id, array $attributes){
        return $this->propriedade->find($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->propriedade->find($id)->delete();
    }
}