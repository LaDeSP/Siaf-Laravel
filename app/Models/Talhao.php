<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Aug 2019 17:18:51 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use function PHPSTORM_META\type;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Balping\HashSlug\HasHashSlug;

class Talhao extends Eloquent{
    use SoftDeletes;
    use HasHashSlug;
    protected $table='talhao';

	protected $casts = [
		'area' => 'int',
		'propriedade_id' => 'int'
	];

	protected $fillable = [
		'area',
		'nome',
        'propriedade_id',
	];

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function plantios(){
		return $this->hasMany(\App\Models\Plantio::class);
    }
    
    
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
    
    /**
    * Método que verifica se um talhão já possui um plantio.
    * Se o talhão possuir plantio ele retorna true e false caso cantrario.
    * @param $idTalhao
    */
    public static function findPlantioTalhao($idTalhao){
        $sucess = DB::table('talhao')
            ->join('plantio', $idTalhao, '=', 'plantio.talhao_id')
            ->first();
        
        if($sucess){
            return true;
        }else{
            return false;
        }
        
    }
}
