<?php
namespace App\Repositories;

use App\Models\Cidade;

class CidadeRepository{
    protected $cidade;
    
    public function __construct(Cidade $cidade){
        $this->cidade = $cidade;
    }

    public function cidadesFindEstado($idEstado){
        return $this->cidade->cidadesByEstado($idEstado);
    }

    public function find($id){
        return $this->cidade->find($id);
    }
}