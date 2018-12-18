<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talhao extends Model
{

    use SoftDeletes;
    protected $table="talhao";

    protected $fillable = [
        'Area'=>"area",
        'Nome'=>'nome',
        'Propriedade'=>"propriedade_id"
    ];

    public static function inserir($data){
        try {
            $talhao = new Talhao();
            $talhao->area = $data['area'];
            $talhao->nome = $data['nome'];
            $talhao->propriedade_id = $data['propriedade_id'];
            $talhao->save();
            return 200;
        }catch(\Exception $e){
            dd($e);
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
            \App\Models\Talhao::find($id)->update(["area" => $request['area'], "nome" => $request['nome']]);
            return 200;
        }catch(\Exception $e){
            return 500;
        }
    }

}
