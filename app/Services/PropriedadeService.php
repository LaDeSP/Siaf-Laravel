<?php
namespace App\Services;

use App\Models\Propriedade;

class PropriedadeService{

    public function create(array $attributes){
        try {
            $propriedade = new Propriedade;
            $propriedade->users_id = $attributes['users_id'];
            $propriedade->nome =  ucwords($attributes['nome']);
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
    
    public function update(array  $attributes, $propriedade){
        try {
            $propriedade->nome = ucwords($attributes['nome']);
            $propriedade->localizacao = $attributes['localizacao'];
            $propriedade->cidade_id = $attributes['cidade'];
            $saved = $propriedade->update();
            if($saved){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

}