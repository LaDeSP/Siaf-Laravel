<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talhao extends Model
{
    use SoftDeletes;
    protected $table="talhao";

    public static function inserir($data){
        try {
            $talhao = new Talhao();
            $talhao->area = $data['area'];
            $talhao->nome = $data['nome'];
            $talhao->propriedade_id = $data['propriedade_id'];
            $talhao->save();
            return 200;
        }catch(\Exception $e){
            return 500;
        }
    }

    /**
     * @param $request
     * @param $id
     * @return \Exception|int
     */
    public static function atualizar($request, $id){
        try{
            $talhao = \App\Models\Talhao::find($id);

            $talhao->area= $request['area'];
            $talhao->nome=$request['nome'];
            $talhao->propriedade_id= $request['propriedade_id'];

            $talhao->save();
            return 200;
        }catch(\Exception $e){
            return $e;
        }
    }

}
