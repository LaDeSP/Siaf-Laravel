<?php
namespace App\Repositories;

use App\Models\Estado;

class EstadoRepository
{
    protected $estado;
    
    public function __construct(Estado $estado){
        $this->estado = $estado;
    }
    
    public function all(){
        return $this->estado->all()->sortBy('nome');
    }

    public function find($id){
        return $this->estado->find($id);
    }
}