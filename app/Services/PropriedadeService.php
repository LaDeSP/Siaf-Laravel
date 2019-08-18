<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\PropriedadeRepository;
use Illuminate\Support\Facades\Auth;

class PropriedadeService
{
    private $propriedadeRepository;

    public function __construct(PropriedadeRepository $propriedade){
        $this->propriedadeRepository = $propriedade;
    }
    
    public function create(array $attributes){
        return $this->propriedadeRepository->create($attributes);
    }
    
    public function read($id){
        return $this->propriedadeRepository->find($id);
    }

    public function propriedadeReadUser(){
        $id = Auth::user()->id;
        return $this->propriedadeRepository->propriedadeFindUser($id);
    }
    
    public function update(Request $request, $id){
        $attributesPropriedade = [];
        $attributesPropriedade['nome']= $request->nome; 
        $attributesPropriedade['localizacao']= $request->localiza; 
        $attributesPropriedade['cidade_id']= $request->cidade;

        $sucess = $this->propriedadeRepository->update($id, $attributesPropriedade);;
        if($sucess == true){
            return $update = [
                'status'=>'success',
                'mensagem'=>'Propriedade atualizada com sucesso!'
            ];
        }else{
            return $update = [
                'status'=>'danger',
                'mensagem'=>'Ocorreu um erro ao atualizar sua propriedade!'
            ];
        }
    }

    public function delete($id){
        return $this->propriedadeRepository->delete($id);
    }
}