<?php

namespace App\Services;

use App\Repositories\TalhaoRepository;
use Illuminate\Http\Request;

class TalhaoService
{
    protected $talhaoRepository;
    
    public function __construct(TalhaoRepository $talhaoRepository){
        $this->talhaoRepository = $talhaoRepository ;
    }
    
    public function index(){
        return $this->talhaoRepository->all();
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