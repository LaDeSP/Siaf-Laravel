<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Propriedade extends Model
{
    protected $table = 'propriedade';
    use SoftDeletes;
    
    public static function inserir($data){
        $propriedade = new Propriedade();
        $propriedade->users_id= $data['cpf'];
        $propriedade->nome=$data['nome'];
        $propriedade->localizacao= $data['localizacao'];
        $propriedade->cidade_id= $data['cidade'];
        $propriedade->save();
    }

    public static function atualizar($request, $id){
        try{
            $prop = \App\Models\Propriedade::find($id);

            $prop->nome = $request['nome'];
            $prop->localizacao= $request['localiza'];
            $prop->cidade_id = $request['cidade'];

            $prop->save();
            return 200;
        }catch(\Exception $e){
            return $e;
        }
    }

}

