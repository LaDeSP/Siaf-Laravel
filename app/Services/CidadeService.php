<?php

namespace App\Services;

use App\Repositories\CidadeRepository;
use Illuminate\Http\Request;

class CidadeService{

    protected $cidadeRepository;

    public function __construct(CidadeRepository $cidade)
    {
        $this->cidadeRepository = $cidade;
    }

    public function read($id){
        return $this->cidadeRepository->find($id);
    }
    
}