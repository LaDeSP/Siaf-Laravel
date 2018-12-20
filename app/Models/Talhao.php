<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function PHPSTORM_META\type;
use Illuminate\Pagination\Paginator;

class Talhao extends Model
{

    use SoftDeletes;
    protected $table="talhao";

    protected $fillable = [
        'Area'=>"area",
        'Nome'=>'nome',
        'Propriedade'=>"propriedade_id",
        'Status'=>'status'
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

    public static function ler($request, $id){
        $talhao =  Talhao::where('propriedade_id','=',$id)->simplePaginate(3,['*'],"talhao");
        if(sizeof($talhao->items())==0 && $talhao->currentPage() > 1)
        {
            return false;
        }
        return $talhao;
    }

}
