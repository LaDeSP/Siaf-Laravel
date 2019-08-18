<?php

namespace App\Services;

use App\Repositories\EstadoRepository;
use Illuminate\Http\Request;

class EstadoService{

    protected $estadoRepository;

    public function __construct(EstadoRepository $estado)
    {
        $this->estadoRepository = $estado ;
    }
    
    public function index(){
        return $this->estadoRepository->all();
    }
    
    public function read($id){
        return $this->estadoRepository->find($id);
    }
}