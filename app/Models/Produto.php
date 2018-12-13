<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table="produto";

    public static function insere($request){
        try{
            $prod = new Produto;
            $prod->nome = $request->nome;
            $prod->status = 1;
            $prod->plantavel = ($request->plantavel=='on'? 1:0);
            $prod->propriedade_id = $request->propriedade_id;
            $prod->unidade_id = $request->unidade_id;
            $prod->save();
            return 200;
        }catch (\Exception $e){
            return 500;
        }
    }

    public static function atualizar($request, $id){
        try{
            return $request;
            $prod = \App\Models\Produto::find($id);
            $prod->nome = $request['nome'];
            $prod->propriedade_id = $request['propriedade_id'];
            $prod->unidade_id = $request['unidade_id'];
            $prod->save();
            return 200;
        }catch(\Exception $e){
            return $e;
        }
    }
}
