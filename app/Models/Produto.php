<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    protected $table="produto";
    use SoftDeletes;

    public static function insere($request){
        try{
            $prod = new Produto();
            $prod->nome = $request->nome;
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
            $prod = \App\Models\Produto::find($id);
            $prod->nome = $request['nome'];
            $prod->propriedade_id = $request['propriedade_id'];
            $prod->unidade_id = $request['unidade_id'];
            $prod->plantavel = ($request->plantavel=='on'? 1:0);
            $prod->save();
            return 200;
        }catch(\Exception $e){
            return $e;
        }
    }
}
