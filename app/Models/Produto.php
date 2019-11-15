<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 19 Sep 2019 08:14:15 -0400.
 */

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Produto extends Eloquent{
	protected $table="produto";
    use SoftDeletes;
    use HasHashSlug;

	protected $casts = [
		'status' => 'bool',
		'propriedade_id' => 'int',
		'unidade_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'tipo',
		'status',
		'propriedade_id',
		'unidade_id'
	];

	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function unidade(){
		return $this->belongsTo(\App\Models\Unidade::class);
	}

	public function estoques(){
		return $this->hasMany(\App\Models\Estoque::class);
	}

	public function plantios(){
		return $this->hasMany(\App\Models\Plantio::class);
	}
	
	public function produtosAtivosEInativos($propriedade){
		$tabelaHistorico = Produto::join('propriedade', 'produto.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as 1','produto.nome as 2',(DB::raw('IF(produto.status = 1, "ativo","inativo") as \'3\'')))
        ->where('produto.propriedade_id', '=', $propriedade->id)
		->groupBy('produto.id','produto.status')
		->orderBy('2', 'asc')
        ->get();
		
		$tabelaResumo = Produto::join('propriedade', 'produto.propriedade_id','=','propriedade.id')
        ->select('propriedade.nome as 1',(DB::raw('IF(produto.status = 1, "ativo","inativo") as \'2\'')), DB::raw('count(*) as \'3\''))
        ->where('produto.propriedade_id', '=', $propriedade->id)
		->groupBy('produto.status')
		->orderBy('3', 'desc')
        ->get();
		
	return [
		'linhasTabelaHistorico'=>$tabelaHistorico,
		'linhasTabelaResumo'=>$tabelaResumo
	];
}
}
