<?php
namespace App\Services;

use App\Models\Propriedade;

class PropriedadeService{

    public function create(array $attributes){
        try {
            $propriedade = new Propriedade;
            $propriedade->users_id = $attributes['users_id'];
            $propriedade->nome =  $attributes['nome'];
            $propriedade->localizacao = $attributes['localizacao'];
            $propriedade->cidade_id =  $attributes['cidade_id'];
            $saved = $propriedade->save();
            if($saved){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
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

}