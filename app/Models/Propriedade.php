<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propriedade extends Model
{
    protected $table = 'propriedade';

    
    public static function inserir($data){
        $propriedade = new Propriedade();
        $propriedade->users_id= $data['cpf'];
        $propriedade->nome=$data['nome'];
        $propriedade->localizacao= $data['localizacao'];
        $propriedade->cidade_id= $data['cidadess'];
        $propriedade->save();
    }
}

